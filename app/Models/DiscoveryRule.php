<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscoveryRule extends Model
{
    protected $fillable = [
        'template_id', 'name', 'key', 'type', 'delay', 'description',
        'snmp_oid', 'url', 'query_fields', 'headers', 'posts', 'post_type', 'timeout'
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function itemPrototypes()
    {
        return $this->hasMany(Item::class, 'discovery_rule_id');
    }

    public function triggerPrototypes()
    {
        return $this->hasMany(Trigger::class, 'discovery_rule_id');
    }

    public function lldMacros()
    {
        return $this->hasMany(Macro::class, 'discovery_rule_id');
    }

    public function preprocessings()
    {
        return $this->hasMany(Preprocessing::class, 'discovery_rule_id')->orderBy('sort_order');
    }
}
