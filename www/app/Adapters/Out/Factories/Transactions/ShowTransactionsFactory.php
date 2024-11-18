<?php

namespace App\Adapters\Out\Factories\Transactions;

use App\Adapters\Out\Persistence\Repositories\TransactionPostgresRepository;
use App\Application\UseCases\Transactions\ShowTransactions\ShowTransactionsUseCase;
use App\Infrasctructure\Database\Postgres;

class ShowTransactionsFactory
{
    public function init(): ShowTransactionsUseCase
    {
        $transactionPostgresRepository = new TransactionPostgresRepository(Postgres::connect());
        
        return new ShowTransactionsUseCase($transactionPostgresRepository);
    }
}