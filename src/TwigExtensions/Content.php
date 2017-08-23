<?php declare(strict_types=1);

namespace App\TwigExtensions;

use App\Blueprint\Blueprint;
use App\Page\Page;
use Slim\Views\TwigExtension;

class Content extends TwigExtension
{
    private $container;
    private $uri;

    public function __construct($container, $uri)
    {
        $this->container = $container;
        $this->uri = $uri;

        parent::__construct($container['router'], $uri);
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('content', array($this, 'getContent')),
        );
    }

    public function getContent($key)
    {
        $path = Helpers::getFirstPathSegment($this->container['request']->getUri()->getPath());

        $page = new Page($path);

        $content = $page->getContent($key);

        if($content)
        {
            return $content;
        }

        $blueprint = new Blueprint();

        $blueprint->setSlug('product');

        $blueprint->setFields([
            $key => [
                'value' => null,
                'type' => null,
            ]
        ]);

        return $blueprint->save();
    }
}