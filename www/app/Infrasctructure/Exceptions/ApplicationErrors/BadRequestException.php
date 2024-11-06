<?php

namespace App\Infrasctructure\Exceptions\ApplicationErrors;

use Exception;

class BadRequestException extends Exception
{
    public function __construct(string $message = "", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}