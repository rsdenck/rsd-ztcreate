<?php

namespace App\Builders\Trigger;

use App\Models\DiscoveryRule;
use App\Models\Trigger;

class TriggerPrototypeBuilder extends TriggerBuilder
{
    /**
     * Cria um protótipo de trigger vinculado a uma regra de descoberta (LLD).
     */
    public function buildPrototype(DiscoveryRule $discoveryRule, array $data): Trigger
    {
        $trigger = $this->build($discoveryRule->template, $data);
        $trigger->discovery_rule_id = $discoveryRule->id;
        
        return $trigger;
    }
}
