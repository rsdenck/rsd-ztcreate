<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TriggerDependency extends Model
{
    protected $fillable = [
        'trigger_id', 'depends_on_trigger_id'
    ];

    public function trigger(): BelongsTo
    {
        return $this->belongsTo(Trigger::class, 'trigger_id');
    }

    public function dependsOnTrigger(): BelongsTo
    {
        return $this->belongsTo(Trigger::class, 'depends_on_trigger_id');
    }
}
