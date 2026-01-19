<?php

namespace App\Builders\Api;

use App\Models\Template;
use App\Models\ApiDefinition;
use Illuminate\Support\Str;

class ApiTemplateBuilder
{
    protected Template $template;
    protected ApiDefinition $apiDefinition;

    public function __construct(Template $template, ApiDefinition $apiDefinition)
    {
        $this->template = $template;
        $this->apiDefinition = $apiDefinition;
    }

    public function build(): Template
    {
        $this->addGlobalMacros();
        $this->addApiTags();
        
        return $this->template;
    }

    protected function addGlobalMacros(): void
    {
        $this->template->macros()->create([
            'macro' => '{$API.URL}',
            'value' => $this->apiDefinition->base_url,
            'description' => 'Base URL for API Template',
        ]);
    }

    protected function addApiTags(): void
    {
        $this->template->tags()->createMany([
            ['tag' => 'vendor', 'value' => $this->apiDefinition->vendor ?? 'Generic'],
            ['tag' => 'api_type', 'value' => $this->apiDefinition->api_type],
        ]);
    }
}
