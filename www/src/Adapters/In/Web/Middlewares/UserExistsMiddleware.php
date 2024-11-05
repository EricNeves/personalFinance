<?php

namespace App\Adapters\In\Web\Middlewares;

use App\Infrasctructure\Http\JWT;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class UserExistsMiddleware
{
    public function handle(Request $request, Response $response, callable $next): void
    {
        $response->json(['oid' => '123']);

        $next($request);
    }
}