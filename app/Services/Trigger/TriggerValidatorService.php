<?php

namespace App\Services\Trigger;

use App\Models\Trigger;

class TriggerValidatorService
{
    /**
     * Valida uma trigger completa.
     */
    public function validate(Trigger $trigger): array
    {
        $errors = [];

        if (empty($trigger->name)) {
            $errors[] = "O nome da trigger é obrigatório.";
        }

        if (empty($trigger->expression)) {
            $errors[] = "A expressão da trigger não pode estar vazia.";
        }

        // Validação básica de parênteses
        if (substr_count($trigger->expression, '(') !== substr_count($trigger->expression, ')')) {
            $errors[] = "A expressão possui parênteses não balanceados.";
        }

        // Validação de severidade
        if ($trigger->priority < 0 || $trigger->priority > 5) {
            $errors[] = "Severidade inválida.";
        }

        return [
            'is_valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Valida se a expressão de recuperação é compatível com a de problema.
     */
    public function validateRecovery(Trigger $trigger): bool
    {
        if ($trigger->recovery_mode == 1 && empty($trigger->recovery_expression)) {
            return false;
        }
        return true;
    }
}
