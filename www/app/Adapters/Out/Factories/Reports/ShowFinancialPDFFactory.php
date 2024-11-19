<?php

namespace App\Adapters\Out\Factories\Reports;

use App\Adapters\Out\Persistence\Repositories\ReportPostgresRepository;
use App\Adapters\Out\Services\BinaryConverterImplementation;
use App\Application\UseCases\Reports\ShowFinancialPDF\ShowFinancialPDFUseCase;
use App\Infrasctructure\Database\Postgres;

class ShowFinancialPDFFactory
{
    public function init(): ShowFinancialPDFUseCase
    {
        $ReportPostgresRepository = new ReportPostgresRepository(Postgres::connect());

        return new ShowFinancialPDFUseCase($ReportPostgresRepository);
    }
}