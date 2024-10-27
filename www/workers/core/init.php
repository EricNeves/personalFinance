<?php

$path = dirname(__DIR__, 2);

require_once "$path/vendor/autoload.php";

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable($path);
$dotenv->load();