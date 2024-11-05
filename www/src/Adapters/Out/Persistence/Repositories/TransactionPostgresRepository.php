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
            return new Transaction(
                $transaction->getId(),
                $transaction->getAmount(),
                $transaction->getDescription(),
                $transaction->getTransactionType(),
                $transaction->getUserId(),
                $transaction->getCreatedAt()
            );
        }

        return null;
    }
}