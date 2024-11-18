<?php

namespace App\Adapters\In\Cli\Works;

use App\Adapters\Out\Jobs\ExportFinancialToPDFJob;
use App\Adapters\Out\Services\ExportFinancialReportToPDFQueueService;
use App\Infrasctructure\Database\RedisDB;

class ExportFinancialToPDFWorker
{
    public static function execute(): void
    {
        $exportFinancialReportToPDFQueueService = new ExportFinancialReportToPDFQueueService(RedisDB::connect());
        $exportFinancialToPDFJob = new ExportFinancialToPDFJob($exportFinancialReportToPDFQueueService);
        
        $exportFinancialToPDFJob->run('generate_pdf');
    }
}