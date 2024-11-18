<?php

namespace App\Application\UseCases\Transactions\ShowTransactions;

use App\Application\DTOs\Transactions\ShowTransactionsDTO;
use App\Domain\Ports\Out\TransactionRepositoryPort;

class ShowTransactionsUseCase implements IShowTransactionsUseCase
{
    public function __construct(private readonly TransactionRepositoryPort $transactionRepositoryPort)
    {
    }
    
    public function execute(ShowTransactionsDTO $showTransactionsDTO): array
    {
        $offset = ($showTransactionsDTO->getPage() - 1) * $showTransactionsDTO->getPerPage();
        
        return $this->transactionRepositoryPort->allPaginated(
            $showTransactionsDTO->getUserId(),
            $offset,
            $showTransactionsDTO->getPerPage()
        );
    }
}