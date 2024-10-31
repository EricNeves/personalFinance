<?php

namespace App\Domain\Enums;

enum TransactionType: string
{
    case INCOME  = 'income';
    case EXPENSE = 'expense';
    
    private function isIncome(): bool
    {
        return $this === self::INCOME;
    }
    
    private function isExpense(): bool
    {
        return $this === self::EXPENSE;
    }
}