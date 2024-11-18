<?php

namespace App\Adapters\Out\Services;

use App\Domain\Services\ExportFinancialReportToPDFQueue;
use Redis;

class ExportFinancialReportToPDFQueueService implements ExportFinancialReportToPDFQueue
{
    public function __construct(private readonly Redis $redis)
    {
    }
    
    public function dispatch(string $key, string $userId): void
    {
        $this->redis->lPush($key, $userId);
    }
    
    public function dequeue(string $key): string
    {
        $queue = $this->redis->brPop($key, 10);
        
        if (!$queue) {
            return '';
        }
        
        [$queueKey, $subject] = $queue;
        
        return $subject ?? '';
    }
}