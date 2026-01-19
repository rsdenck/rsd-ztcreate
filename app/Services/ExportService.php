<?php

namespace App\Services;

use App\Models\Template;
use Illuminate\Support\Str;

class ExportService
{
    public function exportToJson(Template $template): string
    {
        $export = [
            'zabbix_export' => [
                'version' => $template->zabbix_version ?? '7.0',
                'template_groups' => $this->formatGroups($template->groups),
                'templates' => [
                    [
                        'uuid' => $template->uuid ?? Str::uuid()->toString(),
                        'template' => $template->name,
                        'name' => $template->name,
                        'description' => $template->description,
                        'vendor' => [
                            'name' => $template->vendor_name,
                            'version' => $template->vendor_version,
                        ],
                        'groups' => $this->formatGroups($template->groups),
                        'items' => $this->formatItems($template->items),
                        'discovery_rules' => $this->formatDiscoveryRules($template->discoveryRules),
                        'macros' => $this->formatMacros($template->macros),
                        'tags' => $this->formatTags($template->tags),
                    ]
                ],
                'triggers' => $this->formatTriggers($template->triggers),
            ]
        ];

        return json_encode($export, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    private function formatGroups(string $groups): array
    {
        return array_map(fn($g) => ['name' => trim($g)], explode(',', $groups));
    }

    private function formatItems($items): array
    {
        return $items->map(fn($item) => [
            'name' => $item->name,
            'type' => $item->type,
            'key' => $item->key,
            'value_type' => $item->value_type,
            'delay' => $item->delay,
            'history' => $item->history,
            'trends' => $item->trends,
            'status' => $item->status,
            'description' => $item->description,
            'units' => $item->units,
            'snmp_oid' => $item->snmp_oid,
            'preprocessing' => $this->formatPreprocessing($item->preprocessings),
            'tags' => $this->formatTags($item->tags),
            'master_item' => $item->master_item_key ? ['key' => $item->master_item_key] : null,
            'timeout' => $item->timeout,
            'url' => $item->url,
            'query_fields' => $item->query_fields ? json_decode($item->query_fields, true) : null,
            'headers' => $item->headers ? json_decode($item->headers, true) : null,
            'posts' => $item->posts,
            'post_type' => $item->post_type,
        ])->filter()->values()->toArray();
    }

    private function formatDiscoveryRules($rules): array
    {
        return $rules->map(fn($rule) => [
            'name' => $rule->name,
            'type' => $rule->type,
            'key' => $rule->key,
            'delay' => $rule->delay,
            'description' => $rule->description,
            'snmp_oid' => $rule->snmp_oid,
            'item_prototypes' => $this->formatItems($rule->itemPrototypes),
            'trigger_prototypes' => $this->formatTriggers($rule->triggerPrototypes),
            'lld_macro_paths' => $this->formatLldMacros($rule->lldMacros),
            'preprocessing' => $this->formatPreprocessing($rule->preprocessings),
            'timeout' => $rule->timeout,
            'url' => $rule->url,
            'query_fields' => $rule->query_fields ? json_decode($rule->query_fields, true) : null,
            'headers' => $rule->headers ? json_decode($rule->headers, true) : null,
            'posts' => $rule->posts,
            'post_type' => $rule->post_type,
        ])->toArray();
    }

    private function formatTriggers($triggers): array
    {
        return $triggers->map(fn($trigger) => [
            'expression' => $trigger->expression,
            'recovery_mode' => $trigger->recovery_mode,
            'recovery_expression' => $trigger->recovery_expression,
            'name' => $trigger->name,
            'priority' => $trigger->priority,
            'status' => $trigger->status,
            'description' => $trigger->description,
            'tags' => $this->formatTags($trigger->tags),
            'manual_close' => $trigger->manual_close,
        ])->toArray();
    }

    private function formatMacros($macros): array
    {
        return $macros->map(fn($macro) => [
            'macro' => $macro->macro,
            'value' => $macro->value,
            'type' => $macro->type,
            'description' => $macro->description,
        ])->toArray();
    }

    private function formatLldMacros($macros): array
    {
        return $macros->filter(fn($m) => !empty($m->lld_macro))->map(fn($macro) => [
            'lld_macro' => $macro->lld_macro,
            'path' => $macro->path,
        ])->values()->toArray();
    }

    private function formatTags($tags): array
    {
        return $tags->map(fn($tag) => [
            'tag' => $tag->tag,
            'value' => $tag->value,
        ])->toArray();
    }

    private function formatWebScenarios($scenarios): array
    {
        return $scenarios->map(fn($scenario) => [
            'uuid' => $scenario->uuid ?? Str::uuid()->toString(),
            'name' => $scenario->name,
            'delay' => $scenario->delay,
            'retries' => $scenario->retries,
            'agent' => $scenario->agent,
            'http_proxy' => $scenario->http_proxy,
            'variables' => $this->formatKeyValue($scenario->variables),
            'headers' => $this->formatKeyValue($scenario->headers),
            'status' => $scenario->status,
            'authentication' => $scenario->authentication,
            'http_user' => $scenario->http_user,
            'http_password' => $scenario->http_password,
            'verify_peer' => $scenario->verify_peer,
            'verify_host' => $scenario->verify_host,
            'ssl_cert_file' => $scenario->ssl_cert_file,
            'ssl_key_file' => $scenario->ssl_key_file,
            'ssl_key_password' => $scenario->ssl_key_password,
            'steps' => $this->formatWebSteps($scenario->steps),
            'tags' => $this->formatTags($scenario->tags),
        ])->toArray();
    }

    private function formatWebSteps($steps): array
    {
        return $steps->map(fn($step) => [
            'name' => $step->name,
            'url' => $step->url,
            'query_fields' => $this->formatKeyValue($step->query_fields),
            'posts' => $step->posts,
            'variables' => $this->formatKeyValue($step->variables),
            'headers' => $this->formatKeyValue($step->headers),
            'follow_redirects' => $step->follow_redirects,
            'retrieve_mode' => $step->retrieve_mode,
            'timeout' => $step->timeout,
            'required' => $step->required,
            'status_codes' => $step->status_codes,
        ])->toArray();
    }

    private function formatKeyValue($jsonString): array
    {
        if (!$jsonString) {
            return [];
        }

        $data = json_decode($jsonString, true);
        if (!is_array($data)) {
            return [];
        }

        $result = [];
        foreach ($data as $name => $value) {
            $result[] = [
                'name' => $name,
                'value' => $value,
            ];
        }
        return $result;
    }

    private function formatPreprocessing($preprocessings): array
    {
        return $preprocessings->map(fn($p) => [
            'type' => $p->type,
            'parameters' => explode("\n", $p->params),
            'error_handler' => $p->error_handler,
            'error_handler_params' => $p->error_handler_params,
        ])->toArray();
    }
}
