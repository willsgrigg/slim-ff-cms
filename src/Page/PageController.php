<?php declare(strict_types=1);

namespace App\Page;

use App\Services\ConfigService;
use Slim\Http\Request;
use Slim\Http\Response;

class PageController
{
    private $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function show(Request $request, Response $response, array $args)
    {
        $page = $args['page'];

        $page = new Page($page);

        $blueprint = $page->getBlueprint();

        return $this->view->render($response, "$blueprint.html.twig", [
            'site' => ConfigService::getSiteConfig(),
        ]);
    }

    public function edit(Request $request, Response $response, array $args)
    {
        $page = $args['page'];

        $page = new Page($page);

        $blueprint = $page->getBlueprint();

        $config = [
            'edit' => true,
            'pageTitle' => $page->getSlug(),
        ];

        return $this->view->render($response, "$blueprint.html.twig", [
            'site' => ConfigService::getSiteConfig(),
            'config' => $config,
        ]);
    }

    public function create(Request $request, Response $response, array $args)
    {
        $pageName = $request->getParam('value');

        $page = new Page();

        $page->setSlug($pageName);

        $page->setName($pageName);

        $page->setTemplate('product');

        if($page->save())
        {
            return $response->withStatus(200);
        }

        return $response->withStatus(400);
    }

    public function all(Request $request, Response $response, array $args)
    {
        $exclude = $request->getQueryParam('exclude');

        $pages = PageRepository::allExcept($exclude);

        return $response->withJson($pages, 200);
    }

    public function update(Request $request, Response $response, array $args)
    {
//        $page = $args['page'];
//
//        $page = new Page($page);

        return true;
    }
}