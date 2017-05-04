<?php

namespace App;

use PDO;

class DB
{
    private static $dsn = 'mysql:host=localhost;dbname=420px';
    private static $user = 'root';
    private static $password = '';

    private $_db;
    private static $_instance;

    private function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=420px';
        $user = 'root';
        $password = '';

        $this->_db = new PDO($dsn, $user, $password);
        $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    private function __clone()
    {
    }

    public static function get()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance->_db;
    }
}
