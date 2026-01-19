<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trigger extends Model
{
    protected $fillable = [
        'template_id', 'discovery_rule_id', 'name', 'expression', 'recovery_expression',
        'priority', 'status', 'description', 'recovery_mode', 'correlation_mode',
        'correlation_tag', 'manual_close'
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function discoveryRule()
    {
        return $this->belongsTo(DiscoveryRule::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
