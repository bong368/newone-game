<?php

namespace App\Exceptions;

class ApiSignatureException extends ApiException
{
    public function __construct($message = 'Invalid authorization header', $code = 401000)
    {
        parent::__construct(401, $message, $code);
    }
}
