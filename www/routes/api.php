<?php

use App\Infrasctructure\Http\Route;
use App\Adapters\In\Web\Controllers\Overview\HomeController;

Route::get('/', [HomeController::class, 'handle']);