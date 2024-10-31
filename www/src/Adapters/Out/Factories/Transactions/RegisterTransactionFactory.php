<?php

namespace App\Adapters\Out\Factories\Transactions;

use App\Adapters\Out\Services\DateAndTimeImplementation;
use App\Adapters\Out\Services\UuidGeneratorImplementation;
use App\Application\UseCases\Transactions\RegisterTransaction\RegisterTransactionUseCase;

class RegisterTransactionFactory
{
    public function init(): RegisterTransactionUseCase
    {
        $uuidGeneratorImplementation = new UuidGeneratorImplementation();
        $dateAndTimeImplementation   = new DateAndTimeImplementation();
        
        return new RegisterTransactionUseCase(
            $uuidGeneratorImplementation,
            $dateAndTimeImplementation,
        );
    }
}