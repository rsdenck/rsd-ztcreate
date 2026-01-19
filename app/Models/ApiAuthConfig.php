<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiAuthConfig extends Model
{
    protected $fillable = ['api_definition_id', 'auth_type', 'auth_params'];

    protected $casts = [
        'auth_params' => 'array',
    ];

    public function apiDefinition(): BelongsTo
    {
        return $this->belongsTo(ApiDefinition::class);
    }
}
