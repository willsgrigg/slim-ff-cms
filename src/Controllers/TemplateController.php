<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\ConfigService;

class TemplateController
{
    public function all($request, $response)
    {
        $templates = ConfigService::getTemplates();

        return $response->withJson($templates, 200);
    }
}