<?php

require_once './libs/router/router.php';
require_once './app/controllers/banda-api.controller.php';
require_once './app/controllers/concierto-api.controller.php';

$router = new Router();

$router->addRoute(
    'bandas/:id',
    'GET',
    'BandaApiController',
    'getBanda'
);

$router->addRoute(
    'bandas',
    'GET',
    'BandaApiController',
    'getBandas'
);

$router->addRoute(
    'bandas',
    'POST',
    'BandaApiController',
    'insert'
);

$router->addRoute(
    'bandas/:id',
    'PUT',
    'BandaApiController',
    'update'
);

$router->addRoute(
    'conciertos',
    'GET',
    'ConciertoApiController',
    'getConciertos'
);

$router->addRoute(
    'conciertos/:id',
    'PUT',
    'ConciertoApiController',
    'update'
);

$router->setDefaultRoute(
    'BandaApiController',
    'notFound'
);

$router->route(
    $_GET['resource'],
    $_SERVER['REQUEST_METHOD']
);
