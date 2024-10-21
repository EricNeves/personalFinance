<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/bootstrap.php';
require_once __DIR__ . '/routes/api.php';

$middlewares = require_once __DIR__ . '/config/middlewares.php';

use App\Infrasctructure\Http\Route;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

dispatch(Route::getRoutes(), $middlewares);