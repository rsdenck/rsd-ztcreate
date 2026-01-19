<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'template_id', 'item_id', 'discovery_rule_id', 'trigger_id', 'tag', 'value'
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function discoveryRule()
    {
        return $this->belongsTo(DiscoveryRule::class);
    }

    public function trigger()
    {
        return $this->belongsTo(Trigger::class);
    }
}
