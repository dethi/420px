<?php

namespace App;

use Intervention\Image\ImageManagerStatic as ImageManager;

class Filters
{
    public static function apply(string $filepath, string $op, int $level)
    {
        $canvas = ImageManager::make($filepath);
        switch ($op) {
            case 'greyscale':
                $canvas->greyscale();
                break;
            case 'sepia':
                $canvas->greyscale();
                $canvas->colorize(25, 11, 0);
                break;
            case 'gauss':
                $canvas->blur();
                break;
            case 'edge':
                $ressource = $canvas->getCore();
                imagefilter($ressource, IMG_FILTER_EDGEDETECT);
                break;
            case 'pixelate':
                $canvas->pixelate(12);
                break;
            case 'invert':
                $canvas->invert();
                break;
            case 'contrast':
                $canvas->contrast($level);
                break;
            case 'brightness':
                $canvas->brightness($level);
                break;
            default:
                break;
        }

        return $canvas;
    }
}
