<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preprocessing extends Model
{
    protected $fillable = [
        'item_id', 'discovery_rule_id', 'type', 'params', 'error_handler',
        'error_handler_params', 'sort_order'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function discoveryRule()
    {
        return $this->belongsTo(DiscoveryRule::class);
    }
}
