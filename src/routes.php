<?php declare(strict_types=1);

$app->get('/templates', '\App\Controllers\TemplateController:all');

$app->post('/page/create', '\App\Page\PageController:create');

$app->post('/page/update/{page}', '\App\Page\PageController:update');

$app->get('/pages', '\App\Page\PageController:all');

$app->get('/edit/{page}', '\App\Page\PageController:edit');

$app->get('/{page}', '\App\Page\PageController:show');