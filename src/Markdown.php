<?php declare(strict_types=1);

namespace App;

use App\Page\Page;
use Exception;
use Symfony\Component\Yaml\Yaml;

class Markdown
{
    const EXTENSION = '.md';

    public static function update(Page $page)
    {
        foreach(glob($page->getFullPagePath() . "/*" . self::EXTENSION) as $existingPage)
        {
            // only one yaml file exists in each page directory
            $yaml = Yaml::parse(file_get_contents($existingPage));

            $yaml = array_replace_recursive($yaml, $page->getPage());

            return file_put_contents($existingPage, Yaml::dump($yaml));
        }
    }

    public static function save(Page $page)
    {
        $blueprint = $page->getBlueprint();

        if(!mkdir($page->getFullPagePath()))
        {
            throw new Exception('Unable to create directory.');
        }

        $fileName = $page->getFullPagePath() . "/$blueprint" . self::EXTENSION;

        return file_put_contents($fileName, Yaml::dump($page->getPage()));
    }
}