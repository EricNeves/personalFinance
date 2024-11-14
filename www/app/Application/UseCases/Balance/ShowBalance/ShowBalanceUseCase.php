<?php

namespace App\Application\UseCases\Balance\ShowBalance;

use App\Domain\Entities\Balance;
use App\Domain\Ports\Out\BalanceRepositoryPort;
use App\Infrasctructure\Exceptions\ApplicationErrors\NotFoundException;

class ShowBalanceUseCase implements IShowBalanceUseCase
{
    public function __construct(private readonly BalanceRepositoryPort $balanceRepositoryPort)
    {
    }
    
    public function execute(string $userId): Balance
    {
        $balance = $this->balanceRepositoryPort->findByUserId($userId);
        
        if (!$balance) {
            throw new NotFoundException('Sorry, the balance was not found.');
        }
        
        return $balance;
    }
}