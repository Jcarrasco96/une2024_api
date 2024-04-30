<?php

namespace app\exceptions;

use Exception;
use Throwable;

class MethodNotAllowedException extends Exception
{
    public function __construct(string $message = "Método no permitido", ?Throwable $previous = null)
    {
        parent::__construct($message, 405, $previous);
    }

}