<?php

use App\Application\UseCases\Balance\ShowBalance\ShowBalanceUseCase;
use App\Domain\Entities\Balance;
use App\Infrasctructure\Exceptions\ApplicationErrors\NotFoundException;

it('show balance by user id', function () {
    $balanceRepository = mockBalanceRepository();

    $balance = new Balance('1', 100, 0, 0, '1');

    $balanceRepository->shouldReceive('findByUserId')->andReturn($balance);

    $showBalanceUseCase = new ShowBalanceUseCase($balanceRepository);

    expect($showBalanceUseCase->execute('1'))->toBe($balance);
});

it('throws an exception if balance does not exists', function () {
    $balanceRepository = mockBalanceRepository();
    $balanceRepository->shouldReceive('findByUserId')->andReturn(null);

    $showBalanceUseCase = new ShowBalanceUseCase($balanceRepository);

    $showBalanceUseCase->execute('1');
})->throws(NotFoundException::class);