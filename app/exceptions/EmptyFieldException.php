<?php

namespace app\exceptions;

use Throwable;

class EmptyFieldException extends BadRequestException
{
    public function __construct(string $message = "Verifique los campos vacíos.", ?Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }

}