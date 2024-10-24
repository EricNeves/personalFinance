<?php

use App\Infrasctructure\Http\Route;
use App\Adapters\In\Web\Controllers\Users\EditUserController;
use App\Adapters\In\Web\Controllers\Overview\HomeController;
use App\Adapters\In\Web\Controllers\Users\RegisterUserController;
use App\Adapters\In\Web\Controllers\Users\AuthenticateUserController;
use App\Adapters\In\Web\Controllers\Users\FetchUserController;
use App\Adapters\In\Web\Controllers\Users\ChangePasswordController;

/**
 * Overview
 */
Route::get('/', [HomeController::class, 'handle']);

/**
 * User
 */
Route::post('/api/users/register', [RegisterUserController::class, 'handle']);
Route::post('/api/users/authenticate', [AuthenticateUserController::class, 'handle']);
Route::get('/api/users/fetch', [FetchUserController::class, 'handle'])->middlewares('auth');
Route::put('/api/users/info/edit', [EditUserController::class, 'handle'])->middlewares('auth');
Route::put('/api/users/change-password', [ChangePasswordController::class, 'handle'])->middlewares('auth');