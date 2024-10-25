<?php

require_once __DIR__ . '/base_worker.php';

use App\Adapters\In\Jobs\ImageProcessorJob;
use App\Infrasctructure\Database\RedisDB;

$imageProcessorJob = new ImageProcessorJob(RedisDB::connect());

$imageProcessorJob->run('images');