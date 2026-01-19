<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ApiDefinition extends Model
{
    protected $fillable = ['template_id', 'base_url', 'api_type', 'vendor'];

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function authConfig(): HasOne
    {
        return $this->hasOne(ApiAuthConfig::class);
    }

    public function endpoints(): HasMany
    {
        return $this->hasMany(ApiEndpoint::class);
    }
}
