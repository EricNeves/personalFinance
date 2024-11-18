<?php

namespace App\Application\UseCases\Reports\ExportFinancialToPDF;

use App\Domain\Services\ExportFinancialReportToPDFQueue;

class ExportFinancialToPDFUseCase implements IExportFinancialToPDFUseCase
{
    public function __construct(private readonly ExportFinancialReportToPDFQueue $exportFinancialReportToPDFQueue)
    {
    }
    
    public function execute(string $userId): string
    {
        $queueKey = "generate_pdf";
        
        $this->exportFinancialReportToPDFQueue->dispatch($queueKey, $userId);
        
        return 'The report export process has been queued.';
    }
}