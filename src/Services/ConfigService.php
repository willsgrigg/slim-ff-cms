<?php declare(strict_types=1);

namespace App\Services;

use Symfony\Component\Yaml\Yaml;

class ConfigService
{
    const USER_PATH = __DIR__ . '/../../user/';

    const PAGES_PATH = __DIR__ . '/../../user/pages/';

    public static function getSiteConfig(): array
    {
        return Yaml::parse(file_get_contents( self::USER_PATH . 'site.yaml'));
    }

    public static function getPageConfig($page): array
    {
        foreach(glob(self::PAGES_PATH . "$page/*.md") as $page)
        {
            // only one markdown file exists in each page directory
            return Yaml::parse(file_get_contents($page));
        }
    }

    public static function setPageConfig($page, $params)
    {
        foreach(glob(self::PAGES_PATH . "$page/*.md") as $page)
        {
            // only one yaml file exists in each page directory
            $yaml = Yaml::parse(file_get_contents($page));

            $loc = &$yaml;
            foreach(explode('.', $params['field']) as $step)
            {
                $loc = &$loc[$step];
            }
            $loc = $params['value'];

            file_put_contents($page, Yaml::dump($yaml));
        }
    }
}