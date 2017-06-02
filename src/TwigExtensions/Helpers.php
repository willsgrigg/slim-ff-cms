<?php declare(strict_types=1);

namespace App\TwigExtensions;

class Helpers
{
    public static function getFirstPathSegment($path)
    {
        $path = ltrim($path, '/');

        $chunks = preg_split("/\//", $path);

        return $chunks[0];
    }
}