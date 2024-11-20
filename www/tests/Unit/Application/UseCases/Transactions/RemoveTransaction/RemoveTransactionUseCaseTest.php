<?php

use App\Application\UseCases\Transactions\RemoveTransaction\RemoveTransactionUseCase;
use App\Application\DTOs\Transactions\RemoveTransactionDTO;
use App\Domain\Entities\Balance;
use App\Domain\Entities\Transaction;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;
use App\Infrasctructure\Exceptions\ApplicationErrors\NotFoundException;

it('remove transaction', function () {
    $databaseTransactionRepository = mockDatabaseTransactionRepository();
    $balanceRepository             = mockBalanceRepository();
    $transactionRepository         = mockTransactionRepository();
    $calculateFinalValue           = mockCalculateFinalValueTransaction();
    $uuidGenerator                 = mockUuidGenerator();

    $removeTransactionDTO = new RemoveTransactionDTO('4', '1');
    $balance = new Balance('1', 100, 100, 0, '1');
    $transaction = new Transaction(
        '2',
        10,
        'power bills',
        'expense',
        '2024-11-14 00:33:26',
        '1'
    );

    $databaseTransactionRepository->shouldReceive('beginTransaction')->andReturn();
    $uuidGenerator->shouldReceive('isValid')->andReturn(true);
    $balanceRepository->shouldReceive('findByUserId')->andReturn($balance);
    $transactionRepository->shouldReceive('remove')->andReturn($transaction);
    $calculateFinalValue->shouldReceive('calculate')->andReturn($balance);
    $balanceRepository->shouldReceive('updateBalance')->andReturn($balance);
    $databaseTransactionRepository->shouldReceive('commit')->andReturn();

    $removeTransactionUseCase = new RemoveTransactionUseCase(
        $balanceRepository,
        $transactionRepository,
        $databaseTransactionRepository,
        $calculateFinalValue,
        $uuidGenerator
    );

    $remove = $removeTransactionUseCase->execute($removeTransactionDTO);

    expect($remove)->toBeArray();
});

it('remove all transactions if the amount is greater than the balance', function () {
    $databaseTransactionRepository = mockDatabaseTransactionRepository();
    $balanceRepository             = mockBalanceRepository();
    $transactionRepository         = mockTransactionRepository();
    $calculateFinalValue           = mockCalculateFinalValueTransaction();
    $uuidGenerator                 = mockUuidGenerator();

    $removeTransactionDTO = new RemoveTransactionDTO('4', '1');
    $balance = new Balance('1', 100, 100, 0, '1');
    $transaction = new Transaction(
        '2',
        300,
        'power bills',
        'income',
        '2024-11-14 00:33:26',
        '1'
    );

    $databaseTransactionRepository->shouldReceive('beginTransaction')->andReturn();
    $uuidGenerator->shouldReceive('isValid')->andReturn(true);
    $balanceRepository->shouldReceive('findByUserId')->andReturn($balance);
    $transactionRepository->shouldReceive('remove')->andReturn($transaction);
    $calculateFinalValue->shouldReceive('calculate')->andReturn($balance);
    $transactionRepository->shouldReceive('removeAllByUser')->andReturn();
    $balanceRepository->shouldReceive('updateBalance')->andReturn($balance);
    $databaseTransactionRepository->shouldReceive('commit')->andReturn();

    $removeTransactionUseCase = new RemoveTransactionUseCase(
        $balanceRepository,
        $transactionRepository,
        $databaseTransactionRepository,
        $calculateFinalValue,
        $uuidGenerator
    );

    $remove = $removeTransactionUseCase->execute($removeTransactionDTO);

    expect($remove)->toBeArray();
});

it('throws an exception if uuid v4 is not valid', function () {
    $databaseTransactionRepository = mockDatabaseTransactionRepository();
    $balanceRepository             = mockBalanceRepository();
    $transactionRepository         = mockTransactionRepository();
    $calculateFinalValue           = mockCalculateFinalValueTransaction();
    $uuidGenerator                 = mockUuidGenerator();

    $removeTransactionDTO = new RemoveTransactionDTO('4', '1');
    $balance = new Balance('1', 100, 100, 0, '1');
    $transaction = new Transaction(
        '2',
        10,
        'power bills',
        'expense',
        '2024-11-14 00:33:26',
        '1'
    );

    $databaseTransactionRepository->shouldReceive('beginTransaction')->andReturn();
    $uuidGenerator->shouldReceive('isValid')->andReturn(false);
    $balanceRepository->shouldReceive('findByUserId')->andReturn($balance);
    $transactionRepository->shouldReceive('remove')->andReturn($transaction);
    $calculateFinalValue->shouldReceive('calculate')->andReturn($balance);
    $balanceRepository->shouldReceive('updateBalance')->andReturn($balance);
    $databaseTransactionRepository->shouldReceive('commit')->andReturn();

    $removeTransactionUseCase = new RemoveTransactionUseCase(
        $balanceRepository,
        $transactionRepository,
        $databaseTransactionRepository,
        $calculateFinalValue,
        $uuidGenerator
    );

    $removeTransactionUseCase->execute($removeTransactionDTO);
})->throws(BadRequestException::class);

it('throws an exception if balance does not exists', function () {
    $databaseTransactionRepository = mockDatabaseTransactionRepository();
    $balanceRepository             = mockBalanceRepository();
    $transactionRepository         = mockTransactionRepository();
    $calculateFinalValue           = mockCalculateFinalValueTransaction();
    $uuidGenerator                 = mockUuidGenerator();

    $removeTransactionDTO = new RemoveTransactionDTO('4', '1');
    $balance = new Balance('1', 100, 100, 0, '1');
    $transaction = new Transaction(
        '2',
        10,
        'power bills',
        'expense',
        '2024-11-14 00:33:26',
        '1'
    );

    $databaseTransactionRepository->shouldReceive('beginTransaction')->andReturn();
    $uuidGenerator->shouldReceive('isValid')->andReturn(true);
    $balanceRepository->shouldReceive('findByUserId')->andReturn(null);
    $transactionRepository->shouldReceive('remove')->andReturn($transaction);
    $calculateFinalValue->shouldReceive('calculate')->andReturn($balance);
    $balanceRepository->shouldReceive('updateBalance')->andReturn($balance);
    $databaseTransactionRepository->shouldReceive('commit')->andReturn();

    $removeTransactionUseCase = new RemoveTransactionUseCase(
        $balanceRepository,
        $transactionRepository,
        $databaseTransactionRepository,
        $calculateFinalValue,
        $uuidGenerator
    );

    $removeTransactionUseCase->execute($removeTransactionDTO);
})->throws(NotFoundException::class);

it('throws an exception if transaction could not be removed', function () {
    $databaseTransactionRepository = mockDatabaseTransactionRepository();
    $balanceRepository             = mockBalanceRepository();
    $transactionRepository         = mockTransactionRepository();
    $calculateFinalValue           = mockCalculateFinalValueTransaction();
    $uuidGenerator                 = mockUuidGenerator();

    $removeTransactionDTO = new RemoveTransactionDTO('4', '1');
    $balance = new Balance('1', 100, 100, 0, '1');

    $databaseTransactionRepository->shouldReceive('beginTransaction')->andReturn();
    $uuidGenerator->shouldReceive('isValid')->andReturn(true);
    $balanceRepository->shouldReceive('findByUserId')->andReturn($balance);
    $transactionRepository->shouldReceive('remove')->andReturn(null);
    $calculateFinalValue->shouldReceive('calculate')->andReturn($balance);
    $balanceRepository->shouldReceive('updateBalance')->andReturn($balance);
    $databaseTransactionRepository->shouldReceive('commit')->andReturn();

    $removeTransactionUseCase = new RemoveTransactionUseCase(
        $balanceRepository,
        $transactionRepository,
        $databaseTransactionRepository,
        $calculateFinalValue,
        $uuidGenerator
    );

    $removeTransactionUseCase->execute($removeTransactionDTO);
})->throws(BadRequestException::class);

it('throws an exception if balance could not be updated', function () {
    $databaseTransactionRepository = mockDatabaseTransactionRepository();
    $balanceRepository             = mockBalanceRepository();
    $transactionRepository         = mockTransactionRepository();
    $calculateFinalValue           = mockCalculateFinalValueTransaction();
    $uuidGenerator                 = mockUuidGenerator();

    $removeTransactionDTO = new RemoveTransactionDTO('4', '1');
    $balance = new Balance('1', 100, 100, 0, '1');
    $transaction = new Transaction(
        '2',
        10,
        'power bills',
        'expense',
        '2024-11-14 00:33:26',
        '1'
    );

    $databaseTransactionRepository->shouldReceive('beginTransaction')->andReturn();
    $uuidGenerator->shouldReceive('isValid')->andReturn(true);
    $balanceRepository->shouldReceive('findByUserId')->andReturn($balance);
    $transactionRepository->shouldReceive('remove')->andReturn($transaction);
    $calculateFinalValue->shouldReceive('calculate')->andReturn($balance);
    $balanceRepository->shouldReceive('updateBalance')->andReturn(null);
    $databaseTransactionRepository->shouldReceive('commit')->andReturn();

    $removeTransactionUseCase = new RemoveTransactionUseCase(
        $balanceRepository,
        $transactionRepository,
        $databaseTransactionRepository,
        $calculateFinalValue,
        $uuidGenerator
    );

    $removeTransactionUseCase->execute($removeTransactionDTO);
})->throws(BadRequestException::class);