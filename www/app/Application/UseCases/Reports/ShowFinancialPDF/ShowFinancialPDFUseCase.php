<?php

namespace App\Application\UseCases\Reports\ShowFinancialPDF;

use App\Domain\Ports\Out\ReportRepositoryPort;
use App\Infrasctructure\Exceptions\ApplicationErrors\NotFoundException;

class ShowFinancialPDFUseCase implements IShowFinancialPDFUseCase
{
    public function __construct(
        private readonly ReportRepositoryPort $reportRepositoryPort
    ) {
    }

    public function execute(string $userId): string
    {
        $report = $this->reportRepositoryPort->findById($userId);

        if (!$report) {
            throw new NotFoundException('Sorry, the pdf was not found.');
        }

        return $report->getFile();
    }
}