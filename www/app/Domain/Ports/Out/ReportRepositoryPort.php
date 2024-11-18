<?php

namespace App\Domain\Ports\Out;

use App\Domain\Entities\Report;

interface ReportRepositoryPort
{
    public function save(Report $report): ?Report;
    public function exists(string $userId): bool;
    public function update(Report $report): ?Report;
}