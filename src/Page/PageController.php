<?php declare(strict_types=1);

namespace App\Page;

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

        $page = new Page($page);

        $template = $page->getTemplate();

        $config = [
            'edit' => true,
            'pageTitle' => $page->getSlug(),
        ];

        return $this->container['view']->render($response, "$template.html.twig", [
            'site' => ConfigService::getSiteConfig(),
            'page' => $page->getContent(),
            'config' => $config,
        ]);
    }

    public function create($request, $response)
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

    public function all($request, $response)
    {
        $exclude = $request->getQueryParam('exclude');

        $pages = PageRepository::allExcept($exclude);

        return $response->withJson($pages, 200);
    }

    public function update($request, $response, $args)
    {
        $page = $args['page'];

        $page = new Page($page);

        $requestBody = $this->getRequestBody($request, $page);

        $page->setContent($requestBody);

        if($page->update())
        {
            return $response->withStatus(200);
        }

        return $response->withStatus(400);
    }

    public function show($request, $response, $args)
    {
        $page = $args['page'];

        $page = new Page($page);

        $template = $page->getTemplate();

        return $this->container['view']->render($response, "$template.html.twig", [
            'site' => ConfigService::getSiteConfig(),
            'page' => $page->getContent(),
        ]);
    }

    private function getRequestBody($request, $page = null)
    {
        if(!$request->getUploadedFiles())
        {
            return $request->getParams();
        }

        $files = $request->getUploadedFiles();

        return $this->handleFileUpload($files, $page);
    }

    private function handleFileUpload($files, $page)
    {
        foreach($files as $key => $file)
        {
            $key = str_replace('_', '.', $key);

            if ($file->getError() === UPLOAD_ERR_OK) {
                $uploadFileName = $file->getClientFilename();

                $pagesPath = PageRepository::PAGES_PATH;

                $file->moveTo("$pagesPath$page/$uploadFileName");

                return [
                    'field' => "$key.src",
                    'value' => $uploadFileName,
                ];
            }
        }
    }
}