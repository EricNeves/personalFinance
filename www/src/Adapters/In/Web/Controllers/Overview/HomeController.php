<?php

namespace App\Adapters\In\Web\Controllers\Overview;

use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class HomeController
{
    public function handle(Request $request, Response $response): void
    {
        $response->json([
            'author'  => 'Eric Neves <https://github.com/ericneves>',
            'message' => 'Welcome to the api service. 🦅'
        ]);
    }
}
