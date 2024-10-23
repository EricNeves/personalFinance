<?php

use App\Adapters\In\Web\Controllers\Users\EditUserController;
use App\Infrasctructure\Http\Route;
use App\Adapters\In\Web\Controllers\Overview\HomeController;
use App\Adapters\In\Web\Controllers\Users\RegisterUserController;
use App\Adapters\In\Web\Controllers\Users\AuthenticateUserController;
use \App\Adapters\In\Web\Controllers\Users\FetchUserController;

/**
 * Overview
 */
Route::get('/', [HomeController::class, 'handle']);

/**
 * User
 */
Route::post('/users/register', [RegisterUserController::class, 'handle']);
Route::post('/users/authenticate', [AuthenticateUserController::class, 'handle']);
Route::get('/users/fetch', [FetchUserController::class, 'handle'])->middlewares('auth');
Route::put('/users/edit', [EditUserController::class, 'handle'])->middlewares('auth');