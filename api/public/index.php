<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use src\Application\Handlers\HttpErrorHandler;
use src\Application\Handlers\ShutdownHandler;
use src\Middleware\CorsMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$displayErrorDetails = true;

$app = AppFactory::create();
$app->setBasePath("/taskdev/api");

$callableResolver = $app->getCallableResolver();
$responseFactory = $app->getResponseFactory();

$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

$errorHandler = new HttpErrorHandler($callableResolver,$responseFactory);
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

$app->add(CorsMiddleware::class);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Error Handling Middleware
$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, false, false);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Add Error Handling Middleware
$app->addErrorMiddleware(false, false, false);

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!2");
    return $response;
});

$app->run();


