<?php

namespace App\Application\UseCases\Reports\ShowFinancialPDF;

interface IShowFinancialPDFUseCase
{
    public function execute(string $userId): string;
}