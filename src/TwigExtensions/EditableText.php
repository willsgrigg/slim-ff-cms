<?php declare(strict_types=1);

namespace App\TwigExtensions;

use Slim\Views\TwigExtension;

class EditableText extends TwigExtension
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
            new \Twig_SimpleFunction('editable_text', array($this, 'setEditable')),
        );
    }

    public function setEditable($pageContent)
    {
        $path = Helpers::getFirstPathSegment($this->container['request']->getUri()->getPath());

        if($path != 'edit')
        {
            return '';
        }

        return "contenteditable=true data-editable-text-field=$pageContent";
    }
}