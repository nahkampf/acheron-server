<?php

require "../../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('acheron_server');
// if we're in dev mode, log everything
if ($_ENV["MODE"] == "dev") {
    $logger->pushHandler(new StreamHandler(__DIR__ . '/../../logs/server.log', Level::Debug));
} else {
    // but if we're live, then only log warnings and over
    $logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/../server.log', Level::Warning));
}

/* Set up routing */
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
