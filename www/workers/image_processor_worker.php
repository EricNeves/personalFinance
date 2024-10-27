<?php

require_once __DIR__ . '/core/init.php';

use App\Adapters\In\CLI\Works\ImageProcessorWorker;

ImageProcessorWorker::run();