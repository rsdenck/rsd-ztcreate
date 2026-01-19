<?php

namespace App\Builders\Api;

use App\Models\DiscoveryRule;
use App\Models\ApiEndpoint;

class ApiLldBuilder
{
    public function buildFromEndpoint(ApiEndpoint $endpoint, array $lldConfig): DiscoveryRule
    {
        return new DiscoveryRule([
            'name' => $lldConfig['name'],
            'type' => 19, // HTTP Agent
            'key' => $lldConfig['key'],
            'delay' => $endpoint->delay,
            'url' => '{$API.URL}' . $endpoint->path,
            'posts' => $endpoint->payload,
            'headers' => json_encode($endpoint->headers),
            'timeout' => '30s',
        ]);
    }
}
