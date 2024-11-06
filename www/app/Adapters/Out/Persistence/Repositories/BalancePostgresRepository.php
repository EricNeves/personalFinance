<?php

namespace App\Adapters\Out\Persistence\Repositories;

use App\Domain\Entities\Balance;
use App\Domain\Entities\Transaction;
use App\Domain\Ports\Out\BalanceRepositoryPort;
use PDO;

class BalancePostgresRepository implements BalanceRepositoryPort
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function saveInitialBalance(Balance $balance): ?Balance
    {
        $stmt = $this->pdo->prepare('INSERT INTO users_balance (balance, income, expense, user_id) VALUES (?, ?, ?, ?)');
        $stmt->execute([
            $balance->getBalance(),
            $balance->getIncome(),
            $balance->getExpense(),
            $balance->getUserId(),
        ]);

        if ($stmt->rowCount() > 0) {
           return new Balance(
               $balance->getId(),
               $balance->getBalance(),
               $balance->getIncome(),
               $balance->getExpense(),
               $balance->getUserId()
           );
        }

        return null;
    }

    public function findByUserId(string $userId): ?Balance
    {
        $stmt = $this->pdo->prepare('
            SELECT
                id, balance::numeric AS balance, income::numeric AS income, expense::numeric AS expense, user_id
            FROM
                users_balance
            WHERE
                user_id = ?
        ');
        $stmt->execute([$userId]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Balance($row['id'], $row['balance'], $row['income'], $row['expense'], $row['user_id']);
        }

        return null;
    }

    public function updateBalance(Balance $balance): ?Balance
    {
        $stmt = $this->pdo->prepare('
            UPDATE 
                users_balance 
            SET 
                balance = ?::numeric,
                income  = ?::numeric,
                expense = ?::numeric
            WHERE 
                user_id = ?
            RETURNING id, balance::numeric AS balance, income::numeric AS income, expense::numeric AS expense, user_id
        ');

        $stmt->execute([
            $balance->getBalance(),
            $balance->getIncome(),
            $balance->getExpense(),
            $balance->getUserId(),
        ]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Balance($row['id'], $row['balance'], $row['income'], $row['expense'], $row['user_id']);
        }

        return null;
    }
}