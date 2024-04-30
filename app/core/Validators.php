<?php

namespace app\core;

use app\exceptions\BadRequestException;
use app\exceptions\EmptyFieldException;
use app\exceptions\NumericFieldException;
use Exception;

class Validators
{

    /**
     * @throws Exception
     */
    public static function validateSet($message, $data, ...$fields): void
    {
        foreach ($fields as $field) {
            if (!isset($data[$field])) {
                throw new BadRequestException($message);
            }
        }
    }

    /**
     * @throws Exception
     */
    public static function validateNotEmpty(...$fields): void
    {
        foreach ($fields as $field) {
            if (empty($field)) {
                throw new EmptyFieldException();
            }
        }
    }

    /**
     * @throws Exception
     */
    public static function validateIsNumeric($number): void
    {
        if (!is_numeric($number)) {
            throw new NumericFieldException();
        }
    }

}