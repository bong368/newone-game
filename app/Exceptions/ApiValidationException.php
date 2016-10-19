<?php

namespace App\Exceptions;

class ApiValidationException extends ApiException
{
    public function __construct($errors = null, $message = 'Invalid request input', $code = 422000)
    {
        parent::__construct(422, $errors, $message, $code);
    }
}
