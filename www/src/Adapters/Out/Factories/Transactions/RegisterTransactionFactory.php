<?php

namespace App\Adapters\Out\Factories\Transactions;

use App\Adapters\Out\Persistence\Repositories\BalancePostgresRepository;
use App\Adapters\Out\Persistence\Repositories\TransactionPostgresRepository;
use App\Adapters\Out\Services\DatabaseTransactionImplementation;
use App\Adapters\Out\Services\DateAndTimeImplementation;
use App\Adapters\Out\Services\UuidGeneratorImplementation;
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
        $updateBalanceValue            = new UpdateBalanceValue($balancePostgresRepository);
        $transactionTypeValidation     = new TransactionTypeValidation();
        $uuidGeneratorImplementation   = new UuidGeneratorImplementation();
        $dateAndTimeImplementation     = new DateAndTimeImplementation();
        
        return new RegisterTransactionUseCase(
            $transactionPostgresRepository,
            $databaseTransaction,
            $updateBalanceValue,
            $transactionTypeValidation,
            $uuidGeneratorImplementation,
            $dateAndTimeImplementation,
        );
    }
}