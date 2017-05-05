<?php

namespace App;

use Exception;
use App\Auth;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\ImageManagerStatic as Image;

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

    public static function redirectIfGuest(string $url)
    {
        if (!Auth::check()) {
            header("Location: ".$url);
            exit();
        }
    }

    public static function saveUploadedImage($filestruct, $dir)
    {
        switch ($filestruct['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new Exception('Exceeded filesize limit.');
            default:
                throw new Exception('Unknown errors.');
        }

        $filename = tempnam($dir, '');
        unlink($filename);
        $filename = $filename.'.png';

        try {
            $img = Image::make($filestruct['tmp_name']);
            $img->fit(420, 420);
            $img->save($filename);
        } catch (NotReadableException $e) {
            throw new Exception('Cannot read the image. Please try another image.');
        }
        return basename($filename);
    }
}
