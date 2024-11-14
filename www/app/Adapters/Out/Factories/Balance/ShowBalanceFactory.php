<?php

namespace App\Adapters\Out\Factories\Balance;

use App\Adapters\Out\Persistence\Repositories\BalancePostgresRepository;
use App\Application\UseCases\Balance\ShowBalance\ShowBalanceUseCase;
use App\Infrasctructure\Database\Postgres;

class ShowBalanceFactory
{
    public function init(): ShowBalanceUseCase
    {
        $balancePostgresRepository = new BalancePostgresRepository(Postgres::connect());
        
        return new ShowBalanceUseCase($balancePostgresRepository);
    }
}