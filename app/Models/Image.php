<?php

namespace App\Models;

use PDO;
use App\DB;

class Image
{
    public $id;
    public $filename;
    public $user_id;

    private function __construct(int $id, string $filename, int $user_id)
    {
        $this->id = $id;
        $this->filename = $filename;
        $this->user_id = $user_id;
    }

    public static function find(int $id)
    {
        $query = DB::get()->prepare('SELECT * FROM images WHERE id=?');
        if (!$query->execute([$id])) {
            return null;
        }

        $img = $query->fetch(PDO::FETCH_OBJ);
        return new Image($img->id, $img->filename, $img->user_id);
    }

    public static function findByUser(int $user_id)
    {
        $query = DB::get()->prepare('SELECT * FROM images WHERE user_id=?');
        if (!$query->execute([$user_id])) {
            return null;
        }

        // TODO return array
        $img = $query->fetch(PDO::FETCH_OBJ);
        return new Image($img->id, $img->filename, $img->user_id);
    }

    public function save()
    {
        if (empty($this->id)) {
            $query = DB::get()->prepare('INSERT INTO images(filename, user_id) VALUES (?, ?)');
            return $query->execute([$this->filename, $this->user_id]);
        } else {
            throw new Exception("Not implemented");
        }
    }

    public static function create(string $filename, int $user_id)
    {
        return new Image(0, $filename, $user_id);
    }
}
