<?php

namespace App\Adapters\Out\Persistence\Repositories;

use App\Domain\Entities\Transaction;
use App\Domain\Ports\Out\TransactionRepositoryPort;
use PDO;

class TransactionPostgresRepository implements TransactionRepositoryPort
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function save(Transaction $transaction): ?Transaction
    {
        $stmt_transaction = $this->pdo->prepare('
            INSERT
            INTO
                users_transactions (id, amount, description, transaction_type, user_id, created_at)
            VALUES
                (?, ?, ?, ?, ?, ?)
         ');
        $stmt_transaction->execute([
            $transaction->getId(),
            $transaction->getAmount(),
            $transaction->getDescription(),
            $transaction->getTransactionType(),
            $transaction->getUserId(),
            $transaction->getCreatedAt()
        ]);

        if ($stmt_transaction->rowCount() > 0) {
            return $transaction;
        }

        return null;
    }
    
    public function fetchTransactionForUser(string $transactionId, string $userId): ?Transaction
    {
        $stmt = $this->pdo->prepare('
            SELECT
                *, amount::numeric as amount
            FROM
                users_transactions
            WHERE
                id = ?
            AND
                user_id = ?
        ');
        $stmt->execute([$transactionId, $userId]);
        
        $transaction = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$transaction) {
            return null;
        }
        
        return new Transaction(
            $transaction['id'],
            $transaction['amount'],
            $transaction['description'],
            $transaction['transaction_type'],
            $transaction['created_at'],
            $transaction['user_id']
        );
    }
    
    public function remove(string $transactionId, string $userId): ?Transaction
    {
        $transaction = $this->fetchTransactionForUser($transactionId, $userId);
        
        if (!$transaction) {
            return null;
        }
        
        $stmt = $this->pdo->prepare('DELETE FROM users_transactions WHERE id = ?');
        $stmt->execute([$transaction->getId()]);
        
        return $stmt->rowCount() > 0 ? $transaction : null;
    }
    
    public function removeAllByUser(string $userId): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM users_transactions WHERE user_id = ?');
        $stmt->execute([$userId]);
    }
    
    public function all(string $userId): array
    {
        $stmt = $this->pdo->prepare('
            SELECT
                *, amount::numeric as amount
            FROM
                users_transactions
            WHERE
                user_id = ?
        ');
        $stmt->execute([$userId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function allPaginated(string $userId, int $offset = 1, int $limit = 5): array
    {
        $stmt = $this->pdo->prepare('
            SELECT
                id, amount::numeric as amount, transaction_type as "transactionType", user_id as "userId",
                description, created_at as "createdAt"
            FROM
                users_transactions
            WHERE
                user_id = ?
            ORDER BY
                created_at
            DESC
            LIMIT ?
            OFFSET ?
        ');
        $stmt->execute([$userId, $limit, $offset]);
        
        return [
            'items' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => $this->count($userId),
        ];
    }
    
    public function count(string $userId): int
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM users_transactions WHERE user_id = ?');
        $stmt->execute([$userId]);
        
        return $stmt->fetchColumn();
    }
}