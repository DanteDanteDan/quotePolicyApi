<?php

use Slim\App;
use App\Controllers\quotePolicyController;
use App\Controllers\catalogueController;
use Slim\Routing\RouteCollectorProxy;
use Slim\Exception\HttpNotFoundException;

return function (App $app, array $middlewares) {

    // Call container
    $container = $app->getContainer();
    $settings = $container->get('settings');

    define('__BASE_PATH__', $settings['basePath']);

    // CORS requests
    $app->options( __BASE_PATH__ . '{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    // quotePolicyController
    $app->group( __BASE_PATH__ . 'quotePolicy/', function (RouteCollectorProxy $group) use ($middlewares) {

        // View quotePolicyController
        $group->post('', quotePolicyController::class . ':createQuotePolicy');
        // $group->post('', quotePolicyController::class . ':createQuotePolicyORP');
    });

    // catalogueController
    $app->group( __BASE_PATH__ . 'catalogues/', function (RouteCollectorProxy $group) use ($middlewares) {

        // View catalogues
        $group->get('brands_afirme', catalogueController::class . ':carBrandsAfirme');
        $group->get('brands_orp', catalogueController::class . ':carBrandsOrp');
        $group->get('brands', catalogueController::class . ':carBrands');
        $group->get('sub_brands', catalogueController::class . ':subBrands');
        $group->get('description_orp', catalogueController::class . ':descriptionORP');//
        $group->get('description_afirme', catalogueController::class . ':descriptionAfirme');//
        $group->get('description', catalogueController::class . ':description');
    });

    // CORS requests
    $app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],  __BASE_PATH__ . '{routes:.+}', function ($request, $response) {
        throw new HttpNotFoundException($request);
    });
};
