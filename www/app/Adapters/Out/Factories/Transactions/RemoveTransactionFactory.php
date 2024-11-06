<?php

namespace App\Adapters\Out\Factories\Transactions;

use App\Adapters\Out\Persistence\Repositories\BalancePostgresRepository;
use App\Adapters\Out\Persistence\Repositories\TransactionPostgresRepository;
use App\Adapters\Out\Services\DatabaseTransactionImplementation;
use App\Adapters\Out\Services\UuidGeneratorImplementation;
use App\Application\Shared\CalculateFinalValueBalance;
use App\Application\UseCases\Transactions\RemoveTransaction\RemoveTransactionUseCase;
use App\Infrasctructure\Database\Postgres;

class RemoveTransactionFactory
{
    public function init(): RemoveTransactionUseCase
    {
        $transactionPostgresRepository = new TransactionPostgresRepository(Postgres::connect());
        $databaseTransaction           = new DatabaseTransactionImplementation(Postgres::connect());
        $balancePostgresRepository     = new BalancePostgresRepository(Postgres::connect());
        $uuidImplementation            = new UuidGeneratorImplementation();
        $calculateFinalValueBalance    = new CalculateFinalValueBalance();
        
        return new RemoveTransactionUseCase(
            $balancePostgresRepository,
            $transactionPostgresRepository,
            $databaseTransaction,
            $calculateFinalValueBalance,
            $uuidImplementation
        );
    }
}