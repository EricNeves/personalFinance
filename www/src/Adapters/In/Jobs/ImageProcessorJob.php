<?php

namespace App\Adapters\In\Jobs;

use Redis;

class ImageProcessorJob
{
    public function __construct(private readonly Redis $redis)
    {
    }
    
    public function run(string $key): void
    {
        echo "[+] Worker started...\n";
        
        while (true) {
            $queueData = $this->redis->brPop($key, 10);
            
            if ($queueData) {
                print_r($queueData);
                
                echo "[+] Worker finished...\n";
            }
        }
    }
}