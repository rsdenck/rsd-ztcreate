<?php

namespace App\Builders\Api;

use App\Models\Item;
use App\Models\DiscoveryRule;

class ApiItemPrototypeBuilder
{
    public function build(DiscoveryRule $rule, string $metricName, string $jsonPath): Item
    {
        $item = new Item([
            'name' => ucfirst($metricName) . ' for {#NAME}',
            'type' => 18, // Dependent Item
            'key' => 'api.metric[' . $metricName . ',{#ID}]',
            'value_type' => 3, // Numeric Float
            'master_item_key' => $rule->key,
        ]);

        $item->preprocessings()->create([
            'type' => 12, // JSONPath
            'params' => $jsonPath,
        ]);

        return $item;
    }
}
