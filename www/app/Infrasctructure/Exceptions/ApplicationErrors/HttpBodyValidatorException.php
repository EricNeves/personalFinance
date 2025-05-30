<?php

namespace App\Infrasctructure\Exceptions\ApplicationErrors;

use Exception;

class HttpBodyValidatorException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}