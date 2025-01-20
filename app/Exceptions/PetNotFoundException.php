<?php

namespace App\Exceptions;

use Exception;

class PetNotFoundException extends Exception
{
    public function __construct($message = 'Pet not found', $code = 404)
    {
        parent::__construct($message, $code);
    }
}
