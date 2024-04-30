<?php

namespace app\exceptions;

use Exception;
use Throwable;

class NotFoundException extends Exception
{

    public function __construct(string $message = "Recurso no encontrado", ?Throwable $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }

}