<?php

namespace App\Services\Api;

class ApiDiscoveryService
{
    /**
     * Gera propostas de regras de LLD baseadas na análise da API.
     */
    public function proposeLldRules(array $analysis): array
    {
        $rules = [];

        foreach ($analysis['lld_candidates'] as $candidate) {
            $rules[] = [
                'name' => 'Discover ' . ucfirst($candidate['path']),
                'key' => 'api.discovery.' . str_replace('.', '_', $candidate['path']),
                'filter_fields' => $candidate['fields'],
                'path' => $candidate['path'],
            ];
        }

        return $rules;
    }
}
