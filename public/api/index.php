<?php

/**
 * LOAD CODE AND ENV
 */

require "../../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();


/**
 * SET UP LOGGING
 */
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\ErrorHandler;

$logger = new Logger('acheron_backend');
// if we're in dev mode, log everything
if ($_ENV["MODE"] == "dev") {
    $logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/server.log', Level::Debug));
} else {
    // but if we're live, then only log warnings and over
    $logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/server.log', Level::Warning));
}
ErrorHandler::register($logger); // log all errors and exceptions to the logfile

/**
 * SET UP ROUTING
 */
$router = new \Bramus\Router\Router();
$router->mount('/signals/', function () use ($router) {
    // Get all signals
    $router->get('/', function () {
        $signals = Acheron\Signal::getAll();
        Acheron\Output::json($signals);
    });

    $router->get('/(\d+)', function ($id) {
        echo 'get a specific signal by id ' . htmlentities($id);
    });
});

$router->run();
