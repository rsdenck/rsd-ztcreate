<?php

namespace App\Services\Api;

use App\Models\Template;
use App\Models\ApiDefinition;
use App\Models\ApiEndpoint;
use App\Builders\Api\ApiTemplateBuilder;
use App\Builders\Api\ApiLldBuilder;
use App\Builders\Api\ApiItemPrototypeBuilder;
use App\Builders\Api\ApiTriggerPrototypeBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ApiTemplateGeneratorService
{
    protected ApiTemplateBuilder $templateBuilder;
    protected ApiLldBuilder $lldBuilder;
    protected ApiItemPrototypeBuilder $itemBuilder;
    protected ApiTriggerPrototypeBuilder $triggerBuilder;
    protected ApiAnalyzerService $analyzer;

    public function __construct(
        ApiLldBuilder $lldBuilder,
        ApiItemPrototypeBuilder $itemBuilder,
        ApiTriggerPrototypeBuilder $triggerBuilder,
        ApiAnalyzerService $analyzer
    ) {
        $this->lldBuilder = $lldBuilder;
        $this->itemBuilder = $itemBuilder;
        $this->triggerBuilder = $triggerBuilder;
        $this->analyzer = $analyzer;
    }

    /**
     * Gera um objeto Template completo a partir dos dados da API (geralmente da sessão).
     */
    public function generate(array $data): Template
    {
        $template = new Template([
            'name' => $data['name'],
            'groups' => $data['groups'],
            'vendor_name' => $data['vendor_name'] ?? 'RSD ZT',
            'zabbix_version' => $data['zabbix_version'] ?? '7.0',
        ]);

        $apiData = $data['api'];
        $apiDefinition = new ApiDefinition([
            'base_url' => $apiData['base_url'],
            'api_type' => $apiData['api_type'],
            'vendor' => $data['vendor_name'] ?? 'Generic',
        ]);

        // 1. Configurar Template Base (Macros e Tags)
        $this->setupTemplateBase($template, $apiDefinition);

        $discoveryRules = collect();

        // 2. Processar Endpoints para gerar LLD e Protótipos
        foreach ($apiData['endpoints'] as $epData) {
            $endpoint = new ApiEndpoint($epData);
            
            // Simulação de análise (em um cenário real, faríamos um request aqui)
            // Como não podemos fazer requests reais facilmente, vamos assumir uma estrutura padrão
            $analysis = [
                'lld_candidates' => [
                    ['path' => 'data', 'fields' => ['id', 'name', 'status', 'value']]
                ],
                'metrics' => [
                    ['name' => 'health', 'type' => 'numeric'],
                    ['name' => 'uptime', 'type' => 'numeric'],
                ]
            ];

            // Gerar Regras de Descoberta
            foreach ($analysis['lld_candidates'] as $cand) {
                $lldConfig = [
                    'name' => 'Discover ' . Str::title($cand['path']) . ' from ' . $endpoint->path,
                    'key' => 'api.discovery.' . Str::slug($endpoint->path . '_' . $cand['path'], '_'),
                ];
                
                $rule = $this->lldBuilder->buildFromEndpoint($endpoint, $lldConfig);
                
                // Gerar Protótipos de Itens para cada campo da descoberta
                $prototypes = collect();
                foreach ($cand['fields'] as $field) {
                    if (in_array($field, ['id', 'name'])) continue; // Pular campos de identificação
                    
                    $itemPrototype = $this->itemBuilder->build($rule, $field, '$.' . $cand['path'] . '[?(@.id == "{#ID}")].' . $field);
                    $itemPrototype->setRelation('template', $template);
                    $prototypes->push($itemPrototype);

                    // Adicionar Gatilho para métricas críticas (ex: status)
                    if ($field === 'status') {
                        $trigger = $this->triggerBuilder->buildErrorTrigger($itemPrototype);
                        $itemPrototype->setRelation('triggers', collect([$trigger]));
                    }
                }
                
                $rule->setRelation('itemPrototypes', $prototypes);
                $discoveryRules->push($rule);
            }
        }

        $template->setRelation('discoveryRules', $discoveryRules);
        
        // Adicionar Itens Regulares baseados na análise (métricas globais do endpoint)
        $items = collect();
        foreach ($apiData['endpoints'] as $epData) {
            foreach ($analysis['metrics'] as $metric) {
                $items->push(new \App\Models\Item([
                    'name' => Str::title($metric['name']) . ' [' . $epData['path'] . ']',
                    'type' => 19, // HTTP Agent
                    'key' => 'api.' . Str::slug($epData['path'] . '_' . $metric['name'], '_'),
                    'url' => '{$API.URL}' . $epData['path'],
                    'value_type' => $metric['type'] === 'numeric' ? 3 : 1,
                    'delay' => $epData['delay'] ?? '1m',
                ]));
            }
        }
        $template->setRelation('items', $items);

        return $template;
    }

    protected function setupTemplateBase(Template $template, ApiDefinition $apiDefinition): void
    {
        // Macros
        $macros = collect([
            new \App\Models\Macro(['macro' => '{$API.URL}', 'value' => $apiDefinition->base_url]),
            new \App\Models\Macro(['macro' => '{$API.TIMEOUT}', 'value' => '30s']),
        ]);
        $template->setRelation('macros', $macros);

        // Tags
        $tags = collect([
            new \App\Models\Tag(['tag' => 'vendor', 'value' => $apiDefinition->vendor]),
            new \App\Models\Tag(['tag' => 'api_type', 'value' => $apiDefinition->api_type]),
        ]);
        $template->setRelation('tags', $tags);
    }
}
