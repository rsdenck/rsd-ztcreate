<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TriggerFunction extends Model
{
    protected $fillable = [
        'trigger_expression_id', 'item_key', 'function_name', 'parameters', 'operator', 'threshold'
    ];

    public function expression(): BelongsTo
    {
        return $this->belongsTo(TriggerExpression::class, 'trigger_expression_id');
    }
}
