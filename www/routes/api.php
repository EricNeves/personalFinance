<?php

use App\Infrasctructure\Http\Route;
use App\Adapters\In\Web\Controllers\Overview\HomeController;
use App\Adapters\In\Web\Controllers\Users\RegisterUserController;

Route::get('/', [HomeController::class, 'handle']);

Route::post('/users/register', [RegisterUserController::class, 'handle']);