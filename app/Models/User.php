<?php

namespace App\Models;

use PDO;
use App\DB;

class User
{
    public $id;
    public $name;
    public $email;
    private $password;

    private function __construct(int $id, string $name, string $email, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function setPassword(string $password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword(string $password)
    {
        return password_verify($password, $this->password);
    }

    public static function find(int $id)
    {
        $query = DB::get()->prepare('SELECT * FROM users WHERE id=?');
        if (!$query->execute([$id])) {
            return null;
        }

        $user = $query->fetch(PDO::FETCH_OBJ);
        return new User($user->id, $user->name, $user->email, $user->password);
    }

    public static function findByEmail(string $email)
    {
        $query = DB::get()->prepare('SELECT * FROM users WHERE email=?');
        if (!$query->execute([$email])) {
            return null;
        }

        $user = $query->fetch(PDO::FETCH_OBJ);
        return new User($user->id, $user->name, $user->email, $user->password);
    }

    public function save()
    {
        if (empty($this->id)) {
            $query = DB::get()->prepare('INSERT INTO users(name, email, password) VALUES (?, ?, ?)');
            return $query->execute([$this->name, $this->email, $this->password]);
        } else {
            throw new Exception("Not implemented");
        }
    }

    public static function create(string $name, string $email, string $password)
    {
        $user = new User(0, $name, $email, $password);
        $user->setPassword($password);
        return $user;
    }
}
