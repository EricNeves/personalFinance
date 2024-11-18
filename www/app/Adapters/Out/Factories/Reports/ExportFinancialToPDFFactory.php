<?php

namespace App\Adapters\Out\Factories\Reports;

use App\Adapters\Out\Services\ExportFinancialReportToPDFQueueService;
use App\Application\UseCases\Reports\ExportFinancialToPDF\ExportFinancialToPDFUseCase;
use App\Infrasctructure\Database\RedisDB;

class ExportFinancialToPDFFactory
{
    public function init(): ExportFinancialToPDFUseCase
    {
        $exportFinancialReportToPDFQueueService = new ExportFinancialReportToPDFQueueService(RedisDB::connect());
        
        return new ExportFinancialToPDFUseCase($exportFinancialReportToPDFQueueService);
    }
}