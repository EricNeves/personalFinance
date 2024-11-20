<?php

use App\Application\DTOs\Transactions\RegisterTransactionDTO;
use App\Domain\Enums\TransactionType;
use App\Application\UseCases\Transactions\RegisterTransaction\RegisterTransactionUseCase;
use App\Domain\Entities\Balance;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

it('register a transaction', function () {
    $databaseTransactionRepository = mockDatabaseTransactionRepository();
    $balanceRepository             = mockBalanceRepository();
    $registerTransaction           = mockRegisterTransaction();
    $transactionTypeValidator      = mockTransactionTypeValidation();
    $uuidGenerator                 = mockUuidGenerator();
    $dateAndTime                   = mockDateAndTimeService();

    $transactionType = TransactionType::from('income');

    $registerTransactionDTO = new RegisterTransactionDTO(
        100,
        'Transfer In',
        'income',
        '1'
    );

    $balance = new Balance('1', 100, 100, 0, '1');

    $dateAndTime->shouldReceive('currentDateTime')->andReturn('2024-11-14 00:33:26');
    $uuidGenerator->shouldReceive('generateV4')->andReturn('8d8c96d9-a6cd-4231-902c-3f56a9849205');
    $databaseTransactionRepository->shouldReceive('beginTransaction')->andReturn();
    $transactionTypeValidator->shouldReceive('validate')->andReturn($transactionType);
    $registerTransaction->shouldReceive('register')->andReturn();
    $databaseTransactionRepository->shouldReceive('commit')->andReturn();
    $balanceRepository->shouldReceive('findByUserId')->andReturn($balance);

    $registerTransactionUseCase = new RegisterTransactionUseCase(
        $databaseTransactionRepository,
        $registerTransaction,
        $transactionTypeValidator,
        $balanceRepository,
        $uuidGenerator,
        $dateAndTime
    );

    $register = $registerTransactionUseCase->execute($registerTransactionDTO);

    expect($register)->toBeArray();
});