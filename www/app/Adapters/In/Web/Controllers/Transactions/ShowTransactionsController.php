<?php

namespace App\Adapters\In\Web\Controllers\Transactions;

use App\Adapters\Out\Factories\Transactions\ShowTransactionsFactory;
use App\Application\DTOs\Transactions\ShowTransactionsDTO;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class ShowTransactionsController
{
    public function __construct(private readonly ShowTransactionsFactory $showTransactionsFactory)
    {
    }
    
    public function handle(Request $request, Response $response): void
    {
        $body = $request->body();
        $page = is_numeric($body['page']) ? (int) $body['page'] : 1;
        
        $showTransactionsDTO = new ShowTransactionsDTO($request->user()->id(), $page, 4);
        
        $response->json([
            'data' => $this->showTransactionsFactory->init()->execute($showTransactionsDTO),
        ]);
    }
}