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
        $page = $args['page'];

        $parameters = $this->getParameters($request, $page);

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

    private function getParameters($request, $page)
    {
        $parameters = [];

        $requestBody = $this->getRequestBody($request, $page);

        foreach($requestBody as $key => $param){
            $parameters[$key] = $param;
        }

        return $parameters;
    }

    private function getRequestBody($request, $page)
    {
        if(!$request->getUploadedFiles())
        {
            return $request->getParsedBody();
        }

        return $this->handleFileUpload($request, $page);
    }

    private function handleFileUpload($request, $page)
    {
        $files = $request->getUploadedFiles();

        foreach($files as $key => $file)
        {
            $key = str_replace('_', '.', $key);

            if ($file->getError() === UPLOAD_ERR_OK) {
                $uploadFileName = $file->getClientFilename();

                $pagesPath = ConfigService::PAGES_PATH;

                $file->moveTo("$pagesPath$page/$uploadFileName");

                return [
                    'field' => "$key.src",
                    'value' => $uploadFileName,
                ];
            }
        }
    }
}