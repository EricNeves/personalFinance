<?php

namespace App\Adapters\In\Web\Middlewares;

use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class EnsureAuthenticatedMiddleware
{
    public function handle(Request $request, Response $response, callable $next): void
    {
        $next($request);
    }
}