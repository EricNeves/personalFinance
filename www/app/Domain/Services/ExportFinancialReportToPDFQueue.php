<?php

namespace App\Domain\Services;

interface ExportFinancialReportToPDFQueue
{
    public function dispatch(string $key, string $userId): void;
    public function dequeue(string $key): string;
}