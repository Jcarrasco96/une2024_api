<?php

namespace app\exceptions;

use Exception;
use Throwable;

class JsonException extends Exception
{

    public function __construct(?Throwable $previous = null)
    {
        parent::__construct("Error interno en el servidor. Código de error: " . json_last_error(), 500, $previous);
    }


}