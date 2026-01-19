<?php

namespace App\Services\Trigger;

use App\Models\Trigger;
use App\Models\TriggerExpression;
use App\Models\TriggerFunction;

class TriggerExpressionBuilderService
{
    /**
     * Constrói a string da expressão Zabbix a partir dos modelos de TriggerExpression e TriggerFunction.
     */
    public function buildExpression(Trigger $trigger): string
    {
        $expressionParts = [];
        $triggerExpressions = $trigger->triggerExpressions;

        foreach ($triggerExpressions as $index => $expr) {
            $partString = '';
            
            // Se não for a primeira parte, adiciona o operador lógico
            if ($index > 0 && $expr->logical_operator) {
                $partString .= ' ' . $expr->logical_operator . ' ';
            }

            $functionStrings = [];
            foreach ($expr->functions as $func) {
                $functionStrings[] = $this->formatFunction($trigger, $func);
            }

            // Agrupa funções da mesma expressão entre parênteses se houver mais de uma
            $partString .= count($functionStrings) > 1 
                ? '(' . implode(' and ', $functionStrings) . ')' 
                : $functionStrings[0] ?? '';

            $expressionParts[] = $partString;
        }

        return implode('', $expressionParts);
    }

    /**
     * Formata uma única função Zabbix: function(/host/key,params) operator threshold
     */
    private function formatFunction(Trigger $trigger, TriggerFunction $func): string
    {
        $templateName = $trigger->template->name;
        $params = $func->parameters ? ',' . $func->parameters : '';
        
        return sprintf(
            '%s(/%s/%s%s) %s %s',
            $func->function_name,
            $templateName,
            $func->item_key,
            $params,
            $func->operator,
            $func->threshold
        );
    }
}
