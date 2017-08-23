<?php declare(strict_types=1);

namespace App\Controllers;

use App\Services\ConfigService;
use Slim\Http\Request;
use Slim\Http\Response;

class TemplateController
{
    public function all(Request $request, Response $response, array $args)
    {
        $templates = ConfigService::getTemplates();

        return $response->withJson($templates, 200);
    }
}