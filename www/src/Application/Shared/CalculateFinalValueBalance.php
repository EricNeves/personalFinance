<?php

namespace App\Application\Shared;

use App\Domain\Entities\Balance;
use App\Domain\Enums\TransactionType;

class CalculateFinalValueBalance
{
    public function calculate(
        float $currentBalance,
        float $currentIncome,
        float $currentExpense,
        float $amount,
        TransactionType $transactionType,
        string $userId
    ): Balance {
        $incomeValue  = $currentIncome;
        $expenseValue = $currentExpense;
        $finalAmount  = $currentBalance + $amount;
        
        if ($transactionType->isIncome()) {
            $incomeValue += $amount;
        } else {
            $expenseValue += abs($amount);
        }
        
        return new Balance(null, $finalAmount, $incomeValue, $expenseValue, $userId);
    }
}