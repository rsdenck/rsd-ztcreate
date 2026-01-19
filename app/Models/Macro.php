<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Macro extends Model
{
    protected $fillable = [
        'template_id', 'discovery_rule_id', 'macro', 'value', 'type', 'description',
        'lld_macro', 'path'
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function discoveryRule()
    {
        return $this->belongsTo(DiscoveryRule::class);
    }
}
