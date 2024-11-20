<?php

use App\Application\DTOs\Transactions\ShowTransactionsDTO;
use App\Application\UseCases\Transactions\ShowTransactions\ShowTransactionsUseCase;

it('can show all transactions', function () {
    $transactionRepository = mockTransactionRepository();

    $showTransactionsDTO = new ShowTransactionsDTO('1', 1, 1);

    $transactionRepository->shouldReceive('allPaginated')->andReturn([
        'id'                => '1',
        'amount'            => 100.0,
        'description'       => 'Transaction 1',
        'transaction_type'  => 'income',
        'user_id'           => '1'
    ]);

    $showTransactionsUseCase = new ShowTransactionsUseCase($transactionRepository);

    $transactions = $showTransactionsUseCase->execute($showTransactionsDTO);

    expect($transactions)->toBeArray();
});