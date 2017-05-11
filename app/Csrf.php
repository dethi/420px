<?php

namespace App;

class Csrf
{
    private static $_token = null;

    public static function init()
    {
        self::$_token = time() * rand(1, 10);
    }

    public static function check(string $token)
    {
        if (($_SESSION['token'] ?? null) != $token) {
            echo '<p>Invalid CSRF Token.</p>';
            exit();
        }
    }

    public static function field()
    {
        $_SESSION['token'] = self::$_token;
        return '<input type="hidden" name="_token" value="'.self::$_token.'">';
    }
}
