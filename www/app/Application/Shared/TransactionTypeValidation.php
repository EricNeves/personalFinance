<?php

namespace App\Application\Shared;

use App\Domain\Enums\TransactionType;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

class TransactionTypeValidation
{
    public function validate(string $transaction_type): TransactionType
    {
        $transaction_type_enum = TransactionType::tryFrom($transaction_type);

        if (!$transaction_type_enum) {
            throw new BadRequestException('Invalid transaction type, it must be "income" or "expense".');
        }

        return $transaction_type_enum;
    }
}