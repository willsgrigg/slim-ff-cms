<?php declare(strict_types=1);

namespace App\TwigExtensions;

use Parsedown;
use Slim\Views\TwigExtension;

class Markdown extends TwigExtension
{
    private $container;
    private $uri;

    public function __construct($container, $uri)
    {
        $this->container = $container;
        $this->uri = $uri;

        parent::__construct($container['router'], $uri);
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('markdown', array($this, 'markdownFilter')),
        );
    }

    public function markdownFilter($string)
    {
        $parsedown = new Parsedown();

        return $parsedown->text($string);
    }
}