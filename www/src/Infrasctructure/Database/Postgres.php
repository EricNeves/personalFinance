<?php

namespace App\Infrasctructure\Database;

use PDO;

class Postgres
{
    public static function connect(): PDO
    {
        $dns  = "pgsql:host={$_ENV['PG_HOST']}};port={$_ENV['PG_PORT']};dbname={$_ENV['PG_DB']}";
        $user = $_ENV['PG_USER'];
        $pass = $_ENV['PG_PASS'];
        
        return new PDO($dns, $user, $pass);
    }
}