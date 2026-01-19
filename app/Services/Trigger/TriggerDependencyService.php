<?php

namespace App\Services\Trigger;

use App\Models\Trigger;
use App\Models\TriggerDependency;

class TriggerDependencyService
{
    /**
     * Adiciona uma dependência a uma trigger.
     */
    public function addDependency(Trigger $trigger, Trigger $dependsOn): bool
    {
        // Evitar auto-dependência
        if ($trigger->id === $dependsOn->id) {
            return false;
        }

        // Verificar se já existe dependência circular
        if ($this->hasCircularDependency($trigger, $dependsOn)) {
            return false;
        }

        TriggerDependency::firstOrCreate([
            'trigger_id' => $trigger->id,
            'depends_on_trigger_id' => $dependsOn->id
        ]);

        return true;
    }

    /**
     * Verifica recursivamente se existe dependência circular.
     */
    private function hasCircularDependency(Trigger $trigger, Trigger $dependsOn): bool
    {
        // Se a trigger que 'dependsOn' já depende da 'trigger' original, é circular
        $existingDependencies = $dependsOn->dependencies;
        
        foreach ($existingDependencies as $dep) {
            if ($dep->depends_on_trigger_id === $trigger->id) {
                return true;
            }
            if ($this->hasCircularDependency($trigger, $dep->dependsOnTrigger)) {
                return true;
            }
        }

        return false;
    }
}
