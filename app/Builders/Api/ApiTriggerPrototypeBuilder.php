<?php

namespace App\Builders\Api;

use App\Models\Trigger;
use App\Models\Item;

class ApiTriggerPrototypeBuilder
{
    public function buildErrorTrigger(Item $item): Trigger
    {
        return new Trigger([
            'name' => 'API Error on ' . $item->name,
            'expression' => 'nodata(/' . $item->template->name . '/' . $item->key . ',5m)=1',
            'priority' => 4, // High
            'description' => 'No data received from API for 5 minutes.',
        ]);
    }
}
