<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ApiAnalyzerService
{
    /**
     * Analisa uma resposta JSON para identificar potenciais regras de LLD e itens.
     */
    public function analyzeJson(array $data): array
    {
        $analysis = [
            'lld_candidates' => [],
            'metrics' => [],
        ];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if ($this->isList($value)) {
                    $analysis['lld_candidates'][] = [
                        'path' => $key,
                        'fields' => $this->extractFields($value[0] ?? []),
                    ];
                } else {
                    // Recursividade simples para objetos aninhados
                    $nested = $this->analyzeJson($value);
                    foreach ($nested['lld_candidates'] as $cand) {
                        $cand['path'] = $key . '.' . $cand['path'];
                        $analysis['lld_candidates'][] = $cand;
                    }
                }
            } else {
                $analysis['metrics'][] = [
                    'name' => $key,
                    'type' => $this->detectValueType($value),
                ];
            }
        }

        return $analysis;
    }

    private function isList(array $array): bool
    {
        return array_is_list($array) && count($array) > 0 && is_array($array[0]);
    }

    private function extractFields(array $item): array
    {
        return array_keys($item);
    }

    private function detectValueType($value): string
    {
        if (is_numeric($value)) return 'numeric';
        if (is_bool($value)) return 'boolean';
        return 'text';
    }
}
