<?php

namespace App\Adapters\Out\Factories\Transactions;

use App\Adapters\Out\Persistence\Repositories\BalancePostgresRepository;
use App\Adapters\Out\Persistence\Repositories\TransactionPostgresRepository;
use App\Adapters\Out\Services\DatabaseTransactionImplementation;
use App\Adapters\Out\Services\DateAndTimeImplementation;
use App\Adapters\Out\Services\UuidGeneratorImplementation;
use App\Application\Services\Transaction\RegisterTransaction;
use App\Application\Shared\CalculateFinalValueBalance;
use App\Application\Shared\TransactionTypeValidation;
use App\Application\Shared\UpdateBalanceValue;
use App\Application\UseCases\Transactions\RegisterTransaction\RegisterTransactionUseCase;
use App\Infrasctructure\Database\Postgres;

class RegisterTransactionFactory
{
    public function init(): RegisterTransactionUseCase
    {
        $transactionPostgresRepository = new TransactionPostgresRepository(Postgres::connect());
        $databaseTransaction           = new DatabaseTransactionImplementation(Postgres::connect());
        $balancePostgresRepository     = new BalancePostgresRepository(Postgres::connect());
        $calculateFinalValueBalance    = new CalculateFinalValueBalance();
        $transactionTypeValidation     = new TransactionTypeValidation();
        $uuidGeneratorImplementation   = new UuidGeneratorImplementation();
        $dateAndTimeImplementation     = new DateAndTimeImplementation();
        $registerTransaction           = new RegisterTransaction(
            $transactionPostgresRepository,
            $balancePostgresRepository,
            $calculateFinalValueBalance
        );
        
        return new RegisterTransactionUseCase(
            $databaseTransaction,
            $registerTransaction,
            $transactionTypeValidation,
            $balancePostgresRepository,
            $uuidGeneratorImplementation,
            $dateAndTimeImplementation,
        );
    }
}