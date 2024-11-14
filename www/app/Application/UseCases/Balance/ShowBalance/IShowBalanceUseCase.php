<?php

namespace App\Application\UseCases\Balance\ShowBalance;

use App\Domain\Entities\Balance;

interface IShowBalanceUseCase
{
    public function execute(string $userId): Balance;
}