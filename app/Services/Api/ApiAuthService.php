<?php

namespace App\Services\Api;

class ApiAuthService
{
    /**
     * Formata as configurações de autenticação para o formato do Zabbix.
     */
    public function formatAuthForZabbix(string $type, array $params): array
    {
        return match ($type) {
            'ApiKey' => [
                'authtype' => 0,
                'headers' => [['name' => $params['header_name'] ?? 'X-API-KEY', 'value' => $params['api_key'] ?? '']],
            ],
            'Bearer' => [
                'authtype' => 0,
                'headers' => [['name' => 'Authorization', 'value' => 'Bearer ' . ($params['token'] ?? '')]],
            ],
            'Basic' => [
                'authtype' => 1,
                'username' => $params['username'] ?? '',
                'password' => $params['password'] ?? '',
            ],
            default => ['authtype' => 0],
        };
    }
}
