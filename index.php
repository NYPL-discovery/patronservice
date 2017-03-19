<?php
require __DIR__ . '/vendor/autoload.php';

use Slim\Http\Request;
use Slim\Http\Response;
use NYPL\Starter\Service;
use NYPL\Services\Controller;
use NYPL\Starter\SwaggerGenerator;
use NYPL\Starter\Config;

Config::initialize(__DIR__ . '/config');

$service = new Service();

$service->get("/swagger/general", function (Request $request, Response $response) {
    return SwaggerGenerator::generate(
        [__DIR__ . "/src"],
        $response
    );
});

$service->get("/api/v0.1/patrons", function (Request $request, Response $response) {
    $controller = new Controller\PatronController($request, $response);
    return $controller->getPatrons();
});

$service->get("/api/v0.1/patrons/{id}", function (Request $request, Response $response, $parameters) {
    $controller = new Controller\PatronController($request, $response);
    return $controller->getPatron($parameters["id"]);
});

$service->run();
