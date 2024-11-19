<?php

namespace App\Adapters\Out\Persistence\Repositories;

use App\Domain\Entities\Report;
use App\Domain\Ports\Out\ReportRepositoryPort;
use PDO;

class ReportPostgresRepository implements  ReportRepositoryPort
{
    public function __construct(private readonly PDO $pdo)
    {
    }
    
    public function save(Report $report): ?Report
    {
        if ($this->exists($report->getUserId())) {
            return $this->update($report);
        }
        
        $stmt_transaction = $this->pdo->prepare('
            INSERT
            INTO
                users_reports (id, file, user_id)
            VALUES
                (?, ?, ?)
         ');
        $stmt_transaction->execute([
            $report->getId(),
            $report->getFile(),
            $report->getUserId()
        ]);
        
        if ($stmt_transaction->rowCount() > 0) {
            return $report;
        }
        
        return null;
    }
    
    public function exists(string $userId): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM users_reports WHERE user_id = ?');
        $stmt->execute([$userId]);
        
        return $stmt->fetchColumn() > 0;
    }
    
    public function update(Report $report): ?Report
    {
        $stmt = $this->pdo->prepare('
            UPDATE
                users_reports
            SET
                id = ?, file = ?
            WHERE
                user_id = ?
        ');
        $stmt->execute([$report->getId(), $report->getFile(), $report->getUserId()]);
        
        if ($stmt->rowCount() > 0) {
            return $report;
        }
        
        return null;
    }

    public function findById(string $userId): ?Report
    {
        $stmt = $this->pdo->prepare('
            SELECT
                *
            FROM
                users_reports
            WHERE 
                user_id = ?
        ');
        $stmt->execute([$userId]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return new Report($row['id'], stream_get_contents($row['file']), $row['user_id']);
        }

        return null;
    }
}