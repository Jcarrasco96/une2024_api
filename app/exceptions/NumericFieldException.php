<?php

namespace app\exceptions;

use Throwable;

class NumericFieldException extends BadRequestException
{

    public function __construct(string $message = "Verifique que el campo sea un numero.", ?Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }

}