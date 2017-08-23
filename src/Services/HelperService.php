<?php declare(strict_types=1);

namespace App\Services;

class HelperService
{
    public static function makeSlug(string $slug)
    {
        return str_replace(' ', '-', strtolower($slug));
    }
}