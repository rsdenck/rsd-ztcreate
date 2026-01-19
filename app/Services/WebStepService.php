<?php

namespace App\Services;

use App\Models\WebStep;

class WebStepService
{
    public function addStep(int $scenarioId, array $data): WebStep
    {
        return WebStep::create([
            'web_scenario_id' => $scenarioId,
            'name' => $data['name'],
            'url' => $data['url'],
            'query_fields' => isset($data['query_fields']) ? json_encode($data['query_fields']) : null,
            'posts' => $data['posts'] ?? null,
            'variables' => isset($data['variables']) ? json_encode($data['variables']) : null,
            'headers' => isset($data['headers']) ? json_encode($data['headers']) : null,
            'follow_redirects' => $data['follow_redirects'] ?? 1,
            'retrieve_mode' => $data['retrieve_mode'] ?? 0,
            'timeout' => $data['timeout'] ?? '15s',
            'required' => $data['required'] ?? null,
            'status_codes' => $data['status_codes'] ?? null,
            'sortorder' => $data['sortorder'] ?? 0,
        ]);
    }
}
