<?php

use App\Application\Shared\CalculateFinalValueBalance;
use App\Domain\Entities\Balance;
use App\Domain\Enums\TransactionType;

it('calculate final value balance - income', function () {
    $calculateFinalValueBalance = new CalculateFinalValueBalance();

    $currentBalance  = 110.0;
    $currentIncome   = 110.0;
    $currentExpense  = 0.0;
    $amount          = 10.0;
    $transactionType = TransactionType::INCOME;
    $userId          = '1';


    $finalValue = $calculateFinalValueBalance->calculate(
        $currentBalance,
        $currentIncome,
        $currentExpense,
        $amount,
        $transactionType,
        $userId
    );

    expect($finalValue->getBalance())->toBe(120.0);
});

it('calculate final value balance - expense', function () {
    $calculateFinalValueBalance = new CalculateFinalValueBalance();

    $currentBalance  = 110.0;
    $currentIncome   = 110.0;
    $currentExpense  = 0.0;
    $amount          = 10.0;
    $transactionType = TransactionType::EXPENSE;
    $userId          = '1';


    $finalValue = $calculateFinalValueBalance->calculate(
        $currentBalance,
        $currentIncome,
        $currentExpense,
        $amount,
        $transactionType,
        $userId
    );

    expect($finalValue->getExpense())->toBe(10.0);
});