<?php declare(strict_types=1);

namespace App\Services;

use Symfony\Component\Yaml\Yaml;

class ConfigService
{
    const USER_PATH = __DIR__ . '/../../user/';

    public static function getSiteConfig(): array
    {
        return Yaml::parse(file_get_contents( self::USER_PATH . 'site.yaml'));
    }

    public static function getTemplates()
    {
        return Yaml::parse(file_get_contents( self::USER_PATH . 'templates.yaml'));
    }
}