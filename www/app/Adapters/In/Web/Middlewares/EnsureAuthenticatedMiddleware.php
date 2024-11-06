<?php

namespace App\Adapters\In\Web\Middlewares;

use App\Infrasctructure\Http\JWT;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class EnsureAuthenticatedMiddleware
{
    public function handle(Request $request, Response $response, callable $next): void
    {
        $bearerToken = $request->bearerToken();
        $payloadJWT  = JWT::validate($bearerToken);

        if (!$payloadJWT) {
            $response->json(['message' => 'Unauthorized'], 401);
        }

        $request->setUser($payloadJWT);

        $next($request);
    }
}