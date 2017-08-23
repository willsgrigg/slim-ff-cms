<?php declare(strict_types=1);

$app->get('/admin', 'AdminController:show');

$app->get('/admin/{page}', 'AdminController:showPage');

$app->get('/admin/{page}/{field}', 'AdminController:showPageField');

$app->post('/admin/create/{page}/{field}', 'AdminController:createPageField');

//$app->post('/admin/{page}/{field}', 'AdminController:updatePageField');

$app->get('/templates', 'TemplateController:all');

$app->post('/page/create', 'PageController:create');

$app->post('/page/update/{page}', 'PageController:update');

$app->get('/pages', 'PageController:all');

$app->get('/{page}', 'PageController:show');