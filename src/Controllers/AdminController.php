<?php declare(strict_types=1);

namespace App\Controllers;

use App\Blueprint\Blueprint;
use App\Page\Page;
use App\Page\PageRepository;
use App\Services\ConfigService;
use Slim\Http\Request;
use Slim\Http\Response;

class AdminController
{
    private $view;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function show(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, "admin.html.twig", [
            'pages' => PageRepository::all(),
            'site' => ConfigService::getSiteConfig(),
        ]);
    }

    public function showPage(Request $request, Response $response, array $args)
    {
        $page = $args['page'];

        $page = new Page($page);

        $blueprint = new Blueprint($page->getBlueprint());

        return $this->view->render($response, "admin-page.html.twig", [
            'page' => $page->getPage(),
            'fields' => $blueprint->getFields(),
            'site' => ConfigService::getSiteConfig(),
        ]);
    }

    public function showPageField(Request $request, Response $response, array $args)
    {
        $page = $args['page'];

        $page = new Page($page);

        $blueprint = new Blueprint($page->getBlueprint());

        $fieldName = $args['field'];

        $field = $blueprint->getField($fieldName);

        if($field['type'])
        {
            return $this->view->render($response, "admin-page-field.html.twig", [
                'page' => $page->getPage(),
                'field' => $field,
                'site' => ConfigService::getSiteConfig(),
            ]);
        }

        return $this->view->render($response, "admin-page-field-create.html.twig", [
            'page' => $page->getPage(),
            'field' => $fieldName,
            'site' => ConfigService::getSiteConfig(),
        ]);
    }

    public function createPageField(Request $request, Response $response, array $args)
    {
        var_dump('createPageField');die();
        $page = $args['page'];

        $page = new Page($page);

        $blueprint = new Blueprint($page->getBlueprint());

        $fieldName = $args['field'];

        foreach($request->getParams() as $key => $attribute)
        {
            $blueprint->setField($fieldName, $key, $attribute);
        }

        $blueprint->save();

        return $this->showPageField($request, $response, $args);
    }

    public function updatePageField(Request $request, Response $response, array $args)
    {
        var_dump('updatePageField');die();
        $page = $args['page'];

        $page = new Page($page);

        $blueprint = new Blueprint($page->getBlueprint());

        $fieldName = $args['field'];

        foreach($request->getParams() as $key => $attribute)
        {
            $blueprint->setField($fieldName, $key, $attribute);
        }

        $blueprint->save();

        return $this->showPageField($request, $response, $args);
    }
}