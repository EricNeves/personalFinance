<?php

require_once __DIR__ . '/core/init.php';

use App\Adapters\In\Cli\Works\ExportFinancialToPDFWorker;

ExportFinancialToPDFWorker::execute();