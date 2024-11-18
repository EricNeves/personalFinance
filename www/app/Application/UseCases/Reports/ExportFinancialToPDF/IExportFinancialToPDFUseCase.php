<?php

namespace App\Application\UseCases\Reports\ExportFinancialToPDF;

interface IExportFinancialToPDFUseCase
{
    public function execute(string $userId): string;
}