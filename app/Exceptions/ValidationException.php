<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
    public function __construct($message = 'Validation exception', $code = 405)
    {
        parent::__construct($message, $code);
    }
}
