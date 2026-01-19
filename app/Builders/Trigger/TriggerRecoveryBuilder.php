<?php

namespace App\Builders\Trigger;

use App\Models\Trigger;

class TriggerRecoveryBuilder
{
    /**
     * Adiciona lógica de recuperação a uma trigger existente.
     */
    public function addRecovery(Trigger $trigger, string $recoveryExpression): Trigger
    {
        $trigger->recovery_mode = 1; // 1: Recovery expression
        $trigger->recovery_expression = $recoveryExpression;
        
        return $trigger;
    }

    /**
     * Define fechamento manual.
     */
    public function enableManualClose(Trigger $trigger): Trigger
    {
        $trigger->manual_close = 1;
        return $trigger;
    }
}
