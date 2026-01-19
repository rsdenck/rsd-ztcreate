<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'name', 'uuid', 'vendor_name', 'vendor_version', 'description', 'groups', 'zabbix_version'
    ];

    public function items()
    {
        return $this->hasMany(Item::class)->whereNull('discovery_rule_id');
    }

    public function discoveryRules()
    {
        return $this->hasMany(DiscoveryRule::class);
    }

    public function triggers()
    {
        return $this->hasMany(Trigger::class)->whereNull('discovery_rule_id');
    }

    public function macros()
    {
        return $this->hasMany(Macro::class)->whereNull('discovery_rule_id');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
