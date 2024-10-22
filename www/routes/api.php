<?php

use App\Infrasctructure\Http\Route;
use App\Adapters\In\Web\Controllers\Overview\HomeController;
use App\Adapters\In\Web\Controllers\Users\RegisterUserController;
use App\Adapters\In\Web\Controllers\Users\AuthenticateUserController;

Route::get('/', [HomeController::class, 'handle']);

Route::post('/users/register', [RegisterUserController::class, 'handle']);
Route::post('/users/authenticate', [AuthenticateUserController::class, 'handle']);