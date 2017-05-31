<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\ConfigService;
use App\Services\ImageService;

class PageController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function show($request, $response, $args)
    {
        $page = $args['page'];

        $pageConfig = ConfigService::getPageConfig($page);

//        $pageConfig = ImageService::prepareImages($pageConfig);

        $template = $pageConfig['template'];
        
        return $this->container['renderer']->render($response, "$template.phtml", [
            'site' => ConfigService::getSiteConfig(),
            'page' => $pageConfig['content']
        ]);
    }
}