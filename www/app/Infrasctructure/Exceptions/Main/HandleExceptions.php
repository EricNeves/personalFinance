<?php

namespace App\Infrasctructure\Exceptions\Main;

use App\Adapters\Out\Services\DatabaseTransactionImplementation;
use App\Infrasctructure\Database\Postgres;
use App\Infrasctructure\Exceptions\ApplicationErrors\NotFoundException;
use App\Infrasctructure\Exceptions\ApplicationErrors\ServerErrorException;
use App\Infrasctructure\Exceptions\ApplicationErrors\UnauthorizedException;
use App\Infrasctructure\Exceptions\ApplicationErrors\HttpBodyValidatorException;
use App\Infrasctructure\Http\Response;
use Dotenv\Exception\InvalidPathException;
use Exception;
use Throwable;

class HandleExceptions
{
    public static function handle(Throwable $exception): void
    {
        $response = new Response();

        $databaseTransaction = new DatabaseTransactionImplementation(Postgres::connect());

        if ($databaseTransaction->isTransactionActive()) {
            $databaseTransaction->rollback();
        }

        $class_exception = [
            HttpBodyValidatorException::class => ['message' => $exception->getMessage(), 'http_code' => 422],
            UnauthorizedException::class => ['message' => $exception->getMessage(), 'http_code' => 401],
            InvalidPathException::class => ['message' => $exception->getMessage(), 'http_code' => 500],
            ServerErrorException::class => ['message' => $exception->getMessage(), 'http_code' => 500],
            NotFoundException::class => ['message' => $exception->getMessage(), 'http_code' => 404],
            Exception::class => ['message' => $exception->getMessage(), 'http_code' => 400],
            Throwable::class => ['message' => $exception->getMessage(), 'http_code' => 400]
        ];

        foreach ($class_exception as $class_exception_class => $class_exception_value) {
            if ($exception instanceof $class_exception_class) {
                $response->json([
                    'message' => $class_exception_value['message'],
                ], $class_exception_value['http_code']);
            }
        }
    }
}