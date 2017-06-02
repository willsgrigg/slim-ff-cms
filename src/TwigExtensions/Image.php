<?php declare(strict_types=1);

namespace App\TwigExtensions;

use Slim\Views\TwigExtension;

class Image extends TwigExtension
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
            new \Twig_SimpleFunction('image', array($this, 'getImage')),
        );
    }

    public function getImage($image)
    {
        if(!isset($image['alt']))
        {
            $image['alt'] = preg_replace('/\\.[^.\\s]{3,4}$/', '', $image['src']);
        }

        $image['src'] = '/' . $image['src'];

        return $image;
    }
}