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

    public function save(Transaction $transaction): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO users_balance (balance, user_id) VALUES (? ,?)');
        $stmt->execute([$transaction->getAmount(), $transaction->getUserId()]);

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public function hasBalance(Transaction $transaction): ?Balance
    {
        $stmt = $this->pdo->prepare('SELECT balance::numeric AS balance, user_id FROM users_balance WHERE user_id = ?');
        $stmt->execute([$transaction->getUserId()]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Balance((float) $row['balance'], $row['user_id']);
        }

        return null;
    }

    public function updateBalance(float $amount, string $user_id): ?Balance
    {
        $stmt = $this->pdo->prepare('
            UPDATE users_balance 
            SET balance = ?::numeric 
            WHERE user_id = ? 
            RETURNING balance::numeric AS balance, user_id
        ');

        $stmt->execute([$amount, $user_id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Balance((float) $row['balance'], $row['user_id']);
        }

        return null;
    }
}