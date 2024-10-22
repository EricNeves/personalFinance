<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/bootstrap.php';
require_once __DIR__ . '/routes/api.php';

$middlewares = require_once __DIR__ . '/config/middlewares.php';

use App\Infrasctructure\Http\Route;
use App\Infrasctructure\Exceptions\Main\HandleExceptions;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

set_exception_handler([HandleExceptions::class, 'handle']);

dispatch(Route::getRoutes(), $middlewares);
