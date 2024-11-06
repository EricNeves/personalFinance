<?php

use App\Adapters\In\Web\Controllers\Transactions\RegisterTransactionController;
use App\Adapters\In\Web\Controllers\Transactions\RemoveTransactionController;
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
Route::get('/api/users/fetch', [FetchUserController::class, 'handle'])
    ->middlewares('auth', 'userExists');
Route::put('/api/users/info/edit', [EditUserController::class, 'handle'])
    ->middlewares('auth', 'userExists');
Route::put('/api/users/change-password', [ChangePasswordController::class, 'handle'])
    ->middlewares('auth', 'userExists');

/**
 * Transactions
 */
Route::post('/api/transactions/register', [RegisterTransactionController::class, 'handle'])
    ->middlewares('auth', 'userExists');
Route::delete('/api/transactions/{id}/remove', [RemoveTransactionController::class, 'handle'])
    ->middlewares('auth', 'userExists');