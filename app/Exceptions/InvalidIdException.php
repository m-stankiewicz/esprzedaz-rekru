<?php

namespace App\Exceptions;

use Exception;

class InvalidIdException extends Exception
{
    public function __construct($message = 'Invalid ID supplied', $code = 400)
    {
        parent::__construct($message, $code);
    }
}
