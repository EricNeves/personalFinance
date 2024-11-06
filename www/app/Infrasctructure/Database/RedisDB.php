<?php

namespace App\Infrasctructure\Database;

use Redis;

class RedisDB
{
    public static function connect(): Redis
    {
        $redis = new Redis();
        
        $redis->connect($_ENV['REDIS_HOST'], $_ENV['REDIS_PORT']);
        
        return $redis;
    }
}