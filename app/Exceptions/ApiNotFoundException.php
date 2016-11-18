<?php

namespace App\Exceptions;

class ApiNotFoundException extends ApiException
{
    public function __construct($message = 'Object not found', $code = 404000)
    {
        parent::__construct(404, $message, $code);
    }
}
