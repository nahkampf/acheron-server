<?php
header("Access-Control-Allow-Origin: http://acheron-systems.test");
header("Access-Control-Expose-Headers: Content-Length, X-JSON");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: *");
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
use Bramus\Monolog\Formatter\ColoredLineFormatter;

$logger = new Logger('acheron_backend');
// if we're in dev mode, log everything
if ($_ENV["MODE"] == "dev") {
    $handler = new StreamHandler(__DIR__ . '/../../logs/server.log', Level::Debug);
} else {
    // but if we're live, then only log warnings and over
    $handler = new StreamHandler(__DIR__ . '/../../logs/server.log', Level::Warning);
}
$handler->setFormatter(new ColoredLineFormatter());
$logger->pushHandler($handler);
$logger->debug("Game started!");

ErrorHandler::register($logger); // log all errors and exceptions to the logfile

/**
 * SET UP ROUTING
 */
$router = new \Bramus\Router\Router();
$router->post('/register/', function () {
    try {
        // default to setting the IP to the callers IP, but if it is explicitly supplied use that instead
        if (!isset($_POST["ip"])) {
            $_POST["ip"] = $_SERVER['REMOTE_ADDR'];
        }
        $client = new Acheron\Client(@$_POST["id"], @$_POST["ip"]);
        Acheron\Output::json((array)$client);
    } catch (Exception $e) {
        global $logger;
        Acheron\Output::error($e, 500);
        $logger->warning($e->getMessage(), ["REMOTE_ADDR", $_SERVER['REMOTE_ADDR']]);
    }
});

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
