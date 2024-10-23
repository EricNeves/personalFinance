<?php

namespace App\Adapters\In\Web\Controllers\Users;

use App\Adapters\Out\Factories\Users\FetchUserFactory;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class FetchUserController
{
    public function __construct(private readonly FetchUserFactory $fetchUserFactory)
    {
    }

    public function handle(Request $request, Response $response): void
    {
        $info = $this->fetchUserFactory->init()->execute($request->user()->id());

        $response->json([
            'data' => $info
        ]);
    }
}