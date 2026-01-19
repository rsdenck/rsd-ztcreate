<?php

namespace App\Exporters;

use App\Models\Template;
use App\Services\ExportService;

class ZabbixApiTemplateExporter
{
    protected ExportService $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Exporta o template gerado a partir de API para JSON do Zabbix.
     */
    public function export(Template $template): string
    {
        // Garante que o template está carregado com todas as relações geradas
        return $this->exportService->exportToJson($template);
    }
}
