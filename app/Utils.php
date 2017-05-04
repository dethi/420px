<?php

namespace App;

use App\Auth;

class Utils
{
    public static function redirectTo(string $url)
    {
        header("Location: ".$url);
        exit();
    }

    public static function redirectIfAuth(string $url)
    {
        if (Auth::check()) {
            header("Location: ".$url);
            exit();
        }
    }
}
