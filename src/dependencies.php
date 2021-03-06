<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

$container['view'] = function ($c) {
    $settings = $c->get('settings')['view'];
    $view = new \Slim\Views\Twig($settings['template_path'], [
        'cache' => $settings['cache']
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));
    $view->addExtension(new App\TwigExtensions\Image($c, $basePath));
    $view->addExtension(new App\TwigExtensions\Markdown($c, $basePath));
    $view->addExtension(new App\TwigExtensions\Content($c, $basePath));

    return $view;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['AdminController'] = function($c) {
    return new \App\Controllers\AdminController($c['view']);
};

$container['TemplateController'] = function($c) {
    return new \App\Controllers\TemplateController($c['view']);
};

$container['PageController'] = function($c) {
    return new \App\Page\PageController($c['view']);
};
