<?php

require "../../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

/* Set up routing */

$router = new \Bramus\Router\Router();
$router->mount('/signal', function () use ($router) {
    $router->get('/', function () {
        echo 'todo: get all signals';
    });

    $router->get('/(\d+)', function ($id) {
        echo 'get a specific signal by id ' . htmlentities($id);
    });
});

$router->run();
