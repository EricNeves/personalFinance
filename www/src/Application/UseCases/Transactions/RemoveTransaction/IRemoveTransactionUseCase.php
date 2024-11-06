<?php

namespace App\Application\UseCases\Transactions\RemoveTransaction;

use App\Application\DTOs\Transactions\RemoveTransactionDTO;
use App\Domain\Entities\Balance;

interface IRemoveTransactionUseCase
{
    public function execute(RemoveTransactionDTO $removeTransactionDTO): Balance;
}