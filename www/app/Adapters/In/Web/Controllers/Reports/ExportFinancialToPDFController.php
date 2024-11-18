<?php

namespace App\Adapters\In\Web\Controllers\Reports;

use App\Adapters\Out\Factories\Reports\ExportFinancialToPDFFactory;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class ExportFinancialToPDFController
{
    public function __construct(private readonly ExportFinancialToPDFFactory $exportFinancialToPDFFactory)
    {
    }
    
    public function handle(Request $request, Response $response): void
    {
        $response->json([
            'data' => $this->exportFinancialToPDFFactory->init()->execute($request->user()->id())
        ]);
    }
}