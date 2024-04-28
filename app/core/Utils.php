<?php

namespace app\core;

class Utils
{

    public static function randomString($length = 13, $hex = false): ?string
    {
        $str = null;
        $characters = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = $hex ? ceil($length / 2) : $length;

        for ($i = 0; $i < $length; $i++) {
            $random = rand(0, strlen($characters) - 1);
            $str .= $characters[$random];
        }

        return $hex ? bin2hex($str) : $str;
    }

    public static function code($length = 4): ?string
    {
        $str = null;
        $characters = '1234567890';

        for ($i = 0; $i < $length; $i++) {
            $random = rand(0, strlen($characters) - 1);
            $str .= $characters[$random];
        }

        return $str;
    }

}