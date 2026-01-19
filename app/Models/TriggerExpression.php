<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TriggerExpression extends Model
{
    protected $fillable = [
        'trigger_id', 'logical_operator', 'sort_order'
    ];

    public function trigger(): BelongsTo
    {
        return $this->belongsTo(Trigger::class);
    }

    public function functions(): HasMany
    {
        return $this->hasMany(TriggerFunction::class);
    }
}
