<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'template_id', 'discovery_rule_id', 'name', 'key', 'type', 'value_type',
        'delay', 'history', 'trends', 'status', 'description', 'units',
        'snmp_oid', 'url', 'query_fields', 'headers', 'posts', 'post_type',
        'timeout', 'master_item_key'
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function discoveryRule()
    {
        return $this->belongsTo(DiscoveryRule::class);
    }

    public function preprocessings()
    {
        return $this->hasMany(Preprocessing::class)->orderBy('sort_order');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
