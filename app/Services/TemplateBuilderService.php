<?php

namespace App\Services;

use App\Models\Template;
use App\Models\Item;
use App\Models\DiscoveryRule;
use App\Models\Trigger;
use App\Models\Macro;
use App\Models\Tag;
use App\Models\Preprocessing;
use Illuminate\Support\Facades\DB;

class TemplateBuilderService
{
    public function createTemplate(array $data): Template
    {
        return DB::transaction(function () use ($data) {
            $template = Template::create([
                'name' => $data['name'],
                'groups' => $data['groups'],
                'vendor_name' => $data['vendor_name'] ?? null,
                'vendor_version' => $data['vendor_version'] ?? null,
                'description' => $data['description'] ?? null,
                'zabbix_version' => $data['zabbix_version'] ?? '7.0',
            ]);

            if (isset($data['tags'])) {
                foreach ($data['tags'] as $tag) {
                    $template->tags()->create($tag);
                }
            }

            if (isset($data['macros'])) {
                foreach ($data['macros'] as $macro) {
                    $template->macros()->create($macro);
                }
            }

            return $template;
        });
    }

    public function addItem(Template $template, array $data, ?DiscoveryRule $discoveryRule = null): Item
    {
        $itemData = array_merge($data, [
            'template_id' => $template->id,
            'discovery_rule_id' => $discoveryRule?->id,
        ]);

        $item = Item::create($itemData);

        if (isset($data['preprocessing'])) {
            foreach ($data['preprocessing'] as $index => $pre) {
                $item->preprocessings()->create(array_merge($pre, ['sort_order' => $index]));
            }
        }

        if (isset($data['tags'])) {
            foreach ($data['tags'] as $tag) {
                $item->tags()->create($tag);
            }
        }

        return $item;
    }

    public function addDiscoveryRule(Template $template, array $data): DiscoveryRule
    {
        $rule = DiscoveryRule::create(array_merge($data, ['template_id' => $template->id]));

        if (isset($data['preprocessing'])) {
            foreach ($data['preprocessing'] as $index => $pre) {
                $rule->preprocessings()->create(array_merge($pre, ['sort_order' => $index]));
            }
        }

        if (isset($data['lld_macros'])) {
            foreach ($data['lld_macros'] as $macro) {
                $rule->lldMacros()->create($macro);
            }
        }

        return $rule;
    }

    public function addTrigger(Template $template, array $data, ?DiscoveryRule $discoveryRule = null): Trigger
    {
        $triggerData = array_merge($data, [
            'template_id' => $template->id,
            'discovery_rule_id' => $discoveryRule?->id,
        ]);

        $trigger = Trigger::create($triggerData);

        if (isset($data['tags'])) {
            foreach ($data['tags'] as $tag) {
                $trigger->tags()->create($tag);
            }
        }

        return $trigger;
    }
}
