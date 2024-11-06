<?php

namespace App\Adapters\In\Web\Controllers\Transactions;

use App\Adapters\Out\Factories\Transactions\RegisterTransactionFactory;
use App\Application\DTOs\Transactions\RegisterTransactionDTO;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class RegisterTransactionController
{
    public function __construct(private readonly RegisterTransactionFactory $registerTransactionFactory)
    {
    }
    
    public function handle(Request $request, Response $response): void
    {
        $fields = $request->validate([
            'amount'           => 'required|numeric',
            'description'      => 'required',
            'transaction_type' => 'required',
        ]);
        
        $registerTransactionDTO = new RegisterTransactionDTO(
            $fields['amount'],
            $fields['description'],
            $fields['transaction_type'],
            $request->user()->id()
        );
        
        $response->json([
            'data' => $this->registerTransactionFactory->init()->execute($registerTransactionDTO),
        ], 201);
    }
}