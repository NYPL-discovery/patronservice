<?php
require __DIR__ . '/vendor/autoload.php';
set_include_path('/opt/lib64');

use Slim\Http\Request;
use Slim\Http\Response;
use NYPL\Starter\Service;
use NYPL\Services\Controller;
use NYPL\Starter\SwaggerGenerator;
use NYPL\Starter\Config;
use NYPL\Starter\ErrorHandler;

try {
    Config::initialize(__DIR__ . '/config');

    $service = new Service();

    $service->get("/docs/patron", function (Request $request, Response $response) {
        return SwaggerGenerator::generate(
            [__DIR__ . "/src", __DIR__ . "/vendor/nypl/microservice-starter/src"],
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

    $service->post("/api/v0.1/patrons/validate", function (Request $request, Response $response) {
        $controller = new Controller\PatronController($request, $response);
        return $controller->validatePatron();
    });

    $service->run();
} catch (Exception $exception) {
    ErrorHandler::processShutdownError($exception->getMessage(), $exception);
}
