<?php

namespace App\Exceptions;

class HttpNotFoundException extends \Exception
{
    public function __construct(string $message = 'Page Not Found', int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}