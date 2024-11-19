<?php

namespace App\Adapters\In\Web\Controllers\Reports;

use App\Adapters\Out\Factories\Reports\ShowFinancialPDFFactory;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class ShowFinanceReportsPDFController
{
    public function __construct(private readonly ShowFinancialPDFFactory $showFinancialPDFFactory)
    {
    }

    public function handle(Request $request, Response $response): void
    {
        $pdf = $this->showFinancialPDFFactory->init()->execute($request->user()->id());

        $response->pdf('data://application/pdf;base64,'.$pdf);
    }
}