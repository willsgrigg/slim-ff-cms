<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\ConfigService;

class PageController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function edit($request, $response, $args)
    {
        $page = $args['page'];

        $pageConfig = ConfigService::getPageConfig($page);

        $template = $pageConfig['template'];

        $config = [
            'edit' => true,
            'pageTitle' => $page,
        ];

        return $this->container['view']->render($response, "$template.html.twig", [
            'site' => ConfigService::getSiteConfig(),
            'page' => $pageConfig['page'],
            'config' => $config,
        ]);
    }

    public function update($request, $response, $args)
    {
        $parameters = [];

        $page = $args['page'];

        foreach($request->getParsedBody() as $key => $param){
            $parameters[$key] = $param;
        }

        ConfigService::setPageConfig($page, $parameters);
    }

    public function show($request, $response, $args)
    {
        $page = $args['page'];

        $pageConfig = ConfigService::getPageConfig($page);

        $template = $pageConfig['template'];

        return $this->container['view']->render($response, "$template.html.twig", [
            'site' => ConfigService::getSiteConfig(),
            'page' => $pageConfig['page'],
        ]);
    }
}