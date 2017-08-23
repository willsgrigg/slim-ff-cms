<?php declare(strict_types=1);

namespace App\Page;

use Symfony\Component\Yaml\Yaml;

class PageRepository
{
    const PAGES_PATH = __DIR__ . '/../../user/pages/';

    public static function get($page): array
    {
        foreach(glob(self::PAGES_PATH . "$page/*.md") as $page)
        {
            // only one markdown file exists in each page directory
            $yaml = Yaml::parse(file_get_contents($page));

            $yaml['blueprint'] = basename($page, '.md');

            return $yaml;
        }
    }

    public static function getContent($page, $key)
    {
        foreach(glob(self::PAGES_PATH . "$page/*.md") as $page)
        {
            // only one markdown file exists in each page directory
            $page = Yaml::parse(file_get_contents($page));

            return $page[$key];
        }
    }

    public static function all(): array
    {
        $pages = [];

        foreach(glob(self::PAGES_PATH . '*', GLOB_ONLYDIR) as $page)
        {
            $lastSlashPosition = strrpos($page, '/');

            $page = substr($page, $lastSlashPosition + 1);

            $pages[] = $page;
        }

        return $pages;
    }

    public static function allExcept($except = null): array
    {
        $pages = [];

        foreach(glob(self::PAGES_PATH . '*', GLOB_ONLYDIR) as $page)
        {
            $lastSlashPosition = strrpos($page, '/');

            $page = substr($page, $lastSlashPosition + 1);

            if($page !== $except)
            {
                $pages[] = $page;
            }
        }

        return $pages;
    }
}