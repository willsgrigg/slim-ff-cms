<?php declare(strict_types=1);

$app->get('/edit/{page}', '\App\Controllers\PageController:edit');

$app->post('/update/{page}', '\App\Controllers\PageController:update');

$app->get('/{page}', '\App\Controllers\PageController:show');