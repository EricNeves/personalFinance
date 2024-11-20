<?php

use App\Application\Shared\TransactionTypeValidation;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

it('throws an exception if transaction type is invalid', function () {
    $transactionTypeValidation = new TransactionTypeValidation();

    $transactionTypeValidation->validate('invalid');
})->throws(BadRequestException::class);