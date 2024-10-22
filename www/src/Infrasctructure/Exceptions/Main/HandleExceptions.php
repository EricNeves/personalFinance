<?php

namespace App\Infrasctructure\Exceptions\Main;

use App\Infrasctructure\Exceptions\ApplicationErrors\CommonAuthenticateException;
use App\Infrasctructure\Exceptions\ApplicationErrors\HttpBodyValidatorException;
use App\Infrasctructure\Exceptions\ApplicationErrors\RegisterUserException;
use App\Infrasctructure\Http\Response;
use Exception;
use Throwable;

class HandleExceptions
{
    public static function handle(Throwable $exception): void
    {
        $response = new Response();

        $class_exception = [
            HttpBodyValidatorException::class  => ['message' => $exception->getMessage(), 'http_code' => 422],
            CommonAuthenticateException::class => ['message' => $exception->getMessage(), 'http_code' => 401],
            Exception::class => [ 'message' => $exception->getMessage(), 'http_code' => 400],
            Throwable::class => [ 'message' => $exception->getMessage(), 'http_code' => 400]
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