<?php

use App\Domain\Entities\Balance;
use App\Domain\Entities\Transaction;
use App\Domain\Enums\TransactionType;
use App\Application\Services\Transaction\RegisterTransaction;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

it('register a transaction', function () {
    $balanceRepository              = mockBalanceRepository();
    $transactionRepository          = mockTransactionRepository();
    $calculateFinalValueTransaction = mockCalculateFinalValueTransaction();

    $balance = new Balance('1', 100, 0, 0, '1');
    $transaction = new Transaction(
        '1',
        10,
        'power bills',
        'expense',
        '2024-11-14 00:33:26',
        '1'
    );

    $balanceRepository->shouldReceive('findByUserId')->andReturn($balance);
    $transactionRepository->shouldReceive('save')->andReturn($transaction);
    $calculateFinalValueTransaction->shouldReceive('calculate')->andReturn($balance);
    $balanceRepository->shouldReceive('updateBalance')->andReturn($balance);

    $registerTransaction = new RegisterTransaction(
        $transactionRepository,
        $balanceRepository,
        $calculateFinalValueTransaction
    );

    $transactionType = TransactionType::from('expense');

    $registerTransaction->register(100, $transactionType, $transaction);

    expect($registerTransaction)->toBeInstanceOf(RegisterTransaction::class);
});

it('throws an exception if transaction exceeded balance', function () {
    $balanceRepository              = mockBalanceRepository();
    $transactionRepository          = mockTransactionRepository();
    $calculateFinalValueTransaction = mockCalculateFinalValueTransaction();

    $balance = new Balance('1', 10, 0, 0, '1');
    $transaction = new Transaction(
        '1',
        100,
        'power bills',
        'expense',
        '2024-11-14 00:33:26',
        '1'
    );

    $balanceRepository->shouldReceive('findByUserId')->andReturn($balance);

    $registerTransaction = new RegisterTransaction(
        $transactionRepository,
        $balanceRepository,
        $calculateFinalValueTransaction
    );

    $transactionType = TransactionType::from('expense');

    $registerTransaction->register(100, $transactionType, $transaction);
})->throws(BadRequestException::class);

it('throws an exception if transaction is not saved', function () {
    $balanceRepository              = mockBalanceRepository();
    $transactionRepository          = mockTransactionRepository();
    $calculateFinalValueTransaction = mockCalculateFinalValueTransaction();

    $balance = new Balance('1', 10, 0, 0, '1');
    $transaction = new Transaction(
        '1',
        100,
        'power bills',
        'expense',
        '2024-11-14 00:33:26',
        '1'
    );

    $balanceRepository->shouldReceive('findByUserId')->andReturn($balance);
    $transactionRepository->shouldReceive('save')->andReturn(null);

    $registerTransaction = new RegisterTransaction(
        $transactionRepository,
        $balanceRepository,
        $calculateFinalValueTransaction
    );

    $transactionType = TransactionType::from('expense');

    $registerTransaction->register(100, $transactionType, $transaction);
})->throws(BadRequestException::class);

it('throws an exception if balance is not updated', function () {
    $balanceRepository              = mockBalanceRepository();
    $transactionRepository          = mockTransactionRepository();
    $calculateFinalValueTransaction = mockCalculateFinalValueTransaction();

    $balance = new Balance('1', 10, 0, 0, '1');
    $transaction = new Transaction(
        '1',
        100,
        'power bills',
        'expense',
        '2024-11-14 00:33:26',
        '1'
    );

    $balanceRepository->shouldReceive('findByUserId')->andReturn($balance);
    $transactionRepository->shouldReceive('save')->andReturn($transaction);
    $calculateFinalValueTransaction->shouldReceive('calculate')->andReturn($balance);
    $balanceRepository->shouldReceive('updateBalance')->andReturn(null);

    $registerTransaction = new RegisterTransaction(
        $transactionRepository,
        $balanceRepository,
        $calculateFinalValueTransaction
    );

    $transactionType = TransactionType::from('expense');

    $registerTransaction->register(100, $transactionType, $transaction);
})->throws(BadRequestException::class);
