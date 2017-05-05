<?php

namespace App;

use App\Models\User;

class Auth
{
    private const SESSION_KEY = '420px_user_id';
    private static $user = null;

    public static function user()
    {
        if (self::$user == null) {
            $id = $_SESSION[self::SESSION_KEY] ?? null;
            if ($id != null) {
                self::$user = User::find($id);
            }
        }

        return self::$user;
    }

    public static function check()
    {
        return self::user() != null;
    }

    public static function attempt(string $email, $password)
    {
        $user = User::findByEmail($email);
        if (user == null) {
            return false;
        }

        if (!$user->verifyPassword($password)) {
            return false;
        }

        $_SESSION[self::SESSION_KEY] = $user->id;
        return true;
    }

    public static function logout()
    {
        session_destroy();
        $user = null;

        session_start();
        session_regenerate_id(true);
    }
}
