<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiEndpoint extends Model
{
    protected $fillable = ['api_definition_id', 'path', 'method', 'payload', 'headers', 'delay'];

    protected $casts = [
        'headers' => 'array',
    ];

    public function apiDefinition(): BelongsTo
    {
        return $this->belongsTo(ApiDefinition::class);
    }
}
