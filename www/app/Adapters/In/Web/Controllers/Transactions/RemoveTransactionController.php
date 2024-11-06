<?php

namespace App\Adapters\In\Web\Controllers\Transactions;

use App\Adapters\Out\Factories\Transactions\RemoveTransactionFactory;
use App\Application\DTOs\Transactions\RemoveTransactionDTO;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class RemoveTransactionController
{
    public function __construct(private readonly RemoveTransactionFactory $removeTransactionFactory)
    {
    }
    
    public function handle(Request $request, Response $response, array $params): void
    {
        $removeTransactionDTO = new RemoveTransactionDTO($params[0], $request->user()->id());
        
        $response->json([
            'data' => $this->removeTransactionFactory->init()->execute($removeTransactionDTO)
        ]);
    }
}