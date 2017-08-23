<?php declare(strict_types=1);

namespace App\Page;

use App\Markdown;

class Page
{
    const PAGES_PATH = __DIR__ . '/../../user/pages/';

    private $page;

    public function __construct(string $slug = null)
    {
        if($slug)
        {
            $this->page = PageRepository::get($slug);

            $this->setSlug($slug);
        }
    }

    ////////////////////////////////////////////////////////////
    ///////////////////////// GETTERS //////////////////////////
    ////////////////////////////////////////////////////////////

    public function getPage(): array
    {
        return $this->page;
    }

    public function getSlug(): string
    {
        return $this->page['slug'];
    }

    public function getName(): string
    {
        return $this->page['page']['name'];
    }

    public function getBlueprint(): string
    {
        return $this->page['blueprint'];
    }

    public function getContent(string $key = null)
    {
        if($key)
        {
            if(isset($this->page['page'][$key]))
            {
                return $this->page['page'][$key];
            }

            return null;
        }

        return $this->page['page'];
    }

    public function getPagesPath(): string
    {
        return self::PAGES_PATH;
    }

    public function getFullPagePath()
    {
        return $this->getPagesPath() . $this->getSlug();
    }

    ////////////////////////////////////////////////////////////
    ///////////////////////// SETTERS //////////////////////////
    ////////////////////////////////////////////////////////////

    public function setSlug(string $slug): void
    {
        $this->page['slug'] = str_replace(' ', '-', strtolower($slug));
    }

    public function setName(string $name): void
    {
        $this->page['page']['name'] = $name;
    }

    public function setTemplate(string $template): void
    {
        $this->page['template'] = $template;
    }

    public function setContent(array $content): void
    {
        $this->page = array_replace_recursive($this->page, $content);
    }

    public function update()
    {
        return Markdown::update($this);
    }

    public function save()
    {
        return Markdown::save($this);
    }
}