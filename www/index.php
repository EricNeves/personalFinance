<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/bootstrap.php';
require_once __DIR__ . '/routes/api.php';

$middlewares = require_once __DIR__ . '/config/middlewares.php';

use App\Infrasctructure\Http\Route;
use App\Infrasctructure\Exceptions\Main\HandleExceptions;

set_exception_handler([HandleExceptions::class, 'handle']);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

dispatch(Route::getRoutes(), $middlewares);
