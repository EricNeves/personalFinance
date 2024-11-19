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
use App\Adapters\In\Web\Controllers\Balance\ShowBalanceController;
use App\Adapters\In\Web\Controllers\Transactions\ShowTransactionsController;
use App\Adapters\In\Web\Controllers\Reports\ExportFinancialToPDFController;
use App\Adapters\In\Web\Controllers\Reports\ShowFinanceReportsPDFController;

/**
 * Overview
 */
Route::get('/', [HomeController::class, 'handle']);

/**
 * UserModel
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
 * Balance
 */
Route::get('/api/users/balance/fetch', [ShowBalanceController::class, 'handle'])
    ->middlewares('auth', 'userExists');

/**
 * Transactions
 */
Route::post('/api/transactions/register', [RegisterTransactionController::class, 'handle'])
    ->middlewares('auth', 'userExists');
Route::delete('/api/transactions/{id}/remove', [RemoveTransactionController::class, 'handle'])
    ->middlewares('auth', 'userExists');
Route::get('/api/transactions/fetch', [ShowTransactionsController::class, 'handle'])
    ->middlewares('auth', 'userExists');

/**
 * Reports
 */
Route::post('/api/reports/generate/pdf', [ExportFinancialToPDFController::class, 'handle'])
    ->middlewares('auth', 'userExists');
Route::get('/api/reports/view/pdf', [ShowFinanceReportsPDFController::class, 'handle'])
    ->middlewares('auth', 'userExists');