<?php

use App\Domain\Entities\Balance;
use App\Application\Services\Transaction\SaveInitialValueBalance;
use App\Infrasctructure\Exceptions\ApplicationErrors\BadRequestException;

it('register the value of the beginning balance', function () {
    $balanceRepository = mockBalanceRepository();

    $balance = new Balance('1', 100, 0, 0, '1');

    $balanceRepository->shouldReceive('saveInitialBalance')->andReturn($balance);

    $saveInitialValueBalance = new SaveInitialValueBalance($balanceRepository);

    $saveInitialValueBalance->register($balance);

    expect($balance)->toBeInstanceOf(Balance::class);
});

it('throws a exception if balance does not exists', function () {
    $balanceRepository = mockBalanceRepository();

    $balance = new Balance('1', 100, 0, 0, '1');

    $balanceRepository->shouldReceive('saveInitialBalance')->andReturn(null);

    $saveInitialValueBalance = new SaveInitialValueBalance($balanceRepository);

    $saveInitialValueBalance->register($balance);
})->throws(BadRequestException::class);