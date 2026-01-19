<?php

namespace App\Exporters;

use App\Models\Trigger;
use Illuminate\Support\Collection;

class ZabbixTriggerExporter
{
    /**
     * Exporta uma coleção de triggers para o formato array compatível com o JSON do Zabbix.
     */
    public function export(Collection $triggers): array
    {
        return $triggers->map(fn($trigger) => $this->formatTrigger($trigger))->toArray();
    }

    /**
     * Formata uma única trigger para o padrão Zabbix 6.x/7.x.
     */
    private function formatTrigger(Trigger $trigger): array
    {
        $data = [
            'name' => $trigger->name,
            'expression' => $trigger->expression,
            'priority' => $trigger->priority,
            'status' => $trigger->status,
            'description' => $trigger->description,
            'recovery_mode' => $trigger->recovery_mode,
            'manual_close' => $trigger->manual_close,
        ];

        if ($trigger->recovery_mode == 1) {
            $data['recovery_expression'] = $trigger->recovery_expression;
        }

        if ($trigger->tags->count() > 0) {
            $data['tags'] = $trigger->tags->map(fn($tag) => [
                'tag' => $tag->tag,
                'value' => $tag->value,
            ])->toArray();
        }

        if ($trigger->dependencies->count() > 0) {
            $data['dependencies'] = $trigger->dependencies->map(fn($dep) => [
                'name' => $dep->dependsOnTrigger->name,
                'expression' => $dep->dependsOnTrigger->expression,
            ])->toArray();
        }

        return $data;
    }
}
