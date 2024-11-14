<?php

namespace App\Adapters\In\Web\Controllers\Balance;

use App\Adapters\Out\Factories\Balance\ShowBalanceFactory;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class ShowBalanceController
{
    public function __construct(private readonly ShowBalanceFactory $showBalanceFactory)
    {
    }
    
    public function handle(Request $request, Response $response): void
    {
        $response->json([
            'data' => $this->showBalanceFactory->init()->execute($request->user()->id())
        ]);
    }
}