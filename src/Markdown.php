<?php declare(strict_types=1);

use App\Page\Page;
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
        $template = $page->getTemplate();

        $yaml = [
            'page' => [
                'name' => $page->getName()
            ],
            'template' => $template
        ];

        if(!mkdir($page->getFullPagePath()))
        {
            throw new Exception('Unable to create directory.');
        }

        return file_put_contents($page->getFullPagePath() . "/$template" . self::EXTENSION, Yaml::dump($yaml));
    }
}