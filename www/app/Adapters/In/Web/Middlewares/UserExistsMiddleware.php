<?php

namespace App\Adapters\In\Web\Middlewares;

use App\Adapters\Out\Persistence\Repositories\UserPostgresRepository;
use App\Infrasctructure\Database\Postgres;
use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;

class UserExistsMiddleware
{
    public function handle(Request $request, Response $response, callable $next): void
    {
        $userPostgresRepository = new UserPostgresRepository(Postgres::connect());

        $user = $userPostgresRepository->findById($request->user()->id());

        if (!$user) {
            $response->json(['error' => 'Sorry, user not found.'], 404);
        }

        $next($request);
    }
}