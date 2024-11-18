<?php

namespace App\Application\UseCases\Transactions\ShowTransactions;

use App\Application\DTOs\Transactions\ShowTransactionsDTO;

interface IShowTransactionsUseCase
{
    public function execute(ShowTransactionsDTO $showTransactionsDTO): array;
}