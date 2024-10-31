<?php

namespace App\Domain\Enums;

enum TransactionType: string
{
    case INCOME  = 'income';
    case EXPENSE = 'expense';
    
    public function isIncome(): bool
    {
        return $this === self::INCOME;
    }
    
    public function isExpense(): bool
    {
        return $this === self::EXPENSE;
    }
}