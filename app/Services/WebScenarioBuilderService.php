<?php

namespace App\Services;

use App\Models\WebScenario;
use App\Models\WebStep;
use Illuminate\Support\Str;

class WebScenarioBuilderService
{
    public function create(array $data, $parent = null): WebScenario
    {
        $scenarioData = [
            'uuid' => Str::uuid()->toString(),
            'name' => $data['name'],
            'delay' => $data['delay'] ?? '1m',
            'retries' => $data['retries'] ?? 1,
            'agent' => $data['agent'] ?? 'Zabbix',
            'http_proxy' => $data['http_proxy'] ?? null,
            'variables' => isset($data['variables']) ? json_encode($data['variables']) : null,
            'headers' => isset($data['headers']) ? json_encode($data['headers']) : null,
            'status' => $data['status'] ?? 0,
            'authentication' => $data['authentication'] ?? 0,
            'http_user' => $data['http_user'] ?? null,
            'http_password' => $data['http_password'] ?? null,
            'verify_peer' => $data['verify_peer'] ?? 0,
            'verify_host' => $data['verify_host'] ?? 0,
        ];

        if ($parent instanceof \App\Models\Template) {
            $scenarioData['template_id'] = $parent->id;
        } elseif ($parent instanceof \App\Models\DiscoveryRule) {
            $scenarioData['discovery_rule_id'] = $parent->id;
        }

        return WebScenario::create($scenarioData);
    }
}
