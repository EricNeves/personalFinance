<?php

namespace App\Application\UseCases\Transactions\RegisterTransaction;

use App\Application\DTOs\Transactions\RegisterTransactionDTO;
use App\Domain\Entities\Transaction;
use App\Domain\Enums\TransactionType;
use App\Domain\Services\DateAndTime;
use App\Domain\Services\Uuid;

class RegisterTransactionUseCase implements IRegisterTransactionUseCase
{
    public function __construct(
        private readonly Uuid $uuid,
        private readonly DateAndTime $dateAndTime
    ) {
    }
    
    public function execute(RegisterTransactionDTO $registerTransactionDTO): Transaction
    {
        $currentDate = $this->dateAndTime->currentDateTime();
        $uuid        = $this->uuid->generateV4();
        
        $transactionType = TransactionType::from($registerTransactionDTO->getTransactionType());
        
        return new Transaction(
            $uuid,
            $registerTransactionDTO->getAmount(),
            $registerTransactionDTO->getDescription(),
            $transactionType,
            $currentDate
        );
    }
}