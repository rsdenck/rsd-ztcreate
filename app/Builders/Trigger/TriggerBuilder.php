<?php

namespace App\Builders\Trigger;

use App\Models\Template;
use App\Models\Trigger;
use App\Services\Trigger\TriggerExpressionBuilderService;

class TriggerBuilder
{
    protected TriggerExpressionBuilderService $expressionBuilder;

    public function __construct(TriggerExpressionBuilderService $expressionBuilder)
    {
        $this->expressionBuilder = $expressionBuilder;
    }

    /**
     * Cria uma trigger baseada nos dados estruturados do builder inteligente.
     */
    public function build(Template $template, array $data): Trigger
    {
        $trigger = new Trigger([
            'template_id' => $template->id,
            'name' => $data['name'],
            'priority' => $data['priority'] ?? 3,
            'description' => $data['description'] ?? null,
            'recovery_mode' => $data['recovery_mode'] ?? 0,
            'status' => $data['status'] ?? 0,
            'manual_close' => $data['manual_close'] ?? 0,
        ]);

        // Aqui assumimos que as expressões e funções foram salvas e relacionadas à trigger
        // antes de chamar o build final da string da expressão.
        // Em um cenário de Wizard, podemos construir a expressão dinamicamente.
        
        if (isset($data['raw_expression'])) {
            $trigger->expression = $data['raw_expression'];
        }

        return $trigger;
    }
}
