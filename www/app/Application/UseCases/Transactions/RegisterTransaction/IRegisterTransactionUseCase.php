<?php

namespace App\Application\UseCases\Transactions\RegisterTransaction;

use App\Application\DTOs\Transactions\RegisterTransactionDTO;
use App\Domain\Entities\Balance;
use App\Domain\Entities\Transaction;

interface IRegisterTransactionUseCase
{
    public function execute(RegisterTransactionDTO $registerTransactionDTO): Balance;
}