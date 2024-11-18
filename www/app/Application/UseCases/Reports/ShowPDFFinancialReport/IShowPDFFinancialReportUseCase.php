<?php

namespace App\Application\UseCases\Reports\ShowPDFFinancialReport;

interface IShowPDFFinancialReportUseCase
{
    public function execute(string $userId): string;
}