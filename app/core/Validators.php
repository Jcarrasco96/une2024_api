<?php

namespace app\core;

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
                throw new Exception($message, 400);
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
                throw new Exception("Verifique los campos vacios.", 400);
            }
        }
    }

    /**
     * @throws Exception
     */
    public static function validateIsNumeric($number): void
    {
        if (!is_numeric($number)) {
            throw new Exception("Verifique que el campo sea un numero.", 400);
        }
    }

}