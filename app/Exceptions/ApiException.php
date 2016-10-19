<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\MessageBag;

class ApiException extends HttpException
{
    /**
     * MessageBag errors.
     *
     * @var \Illuminate\Support\MessageBag
     */
    private $errors;

    public function __construct($statusCode, $errors = null, $message = null, $code = 0)
    {
        if (is_null($errors)) {
            $this->errors = new MessageBag();
        } else {
            $this->errors = is_array($errors) ? new MessageBag($errors) : $errors;
        }

        parent::__construct($statusCode, $message, null, [], $code);
    }

    /**
     * Get the errors message bag.
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Determine if message bag has any errors.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return !$this->errors->isEmpty();
    }
}
