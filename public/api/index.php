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
use Monolog\Formatter\LineFormatter;
use Bramus\Monolog\Formatter\ColoredLineFormatter;
use Acheron\DB;

/* we have two logs, the "full" log, and the "narrative" log (which is more
meant to give a sort of narrative view of what happened system-wise during
the game)
*/
$dateFormat = "Y-m-d H:i:s";
$output = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";

$logger = new Logger('acheron_API_full');
$handler = new StreamHandler(__DIR__ . '/../../logs/server.log', Level::Debug);
$handler->setFormatter(new ColoredLineFormatter(null, $output, $dateFormat));
$logger->pushHandler($handler);
ErrorHandler::register($logger); // log all errors and exceptions to the logfile

$narrativeLog = new Logger('acheron_narrative');
$handlerNarrative = new StreamHandler(__DIR__ . '/../../logs/narrative.log', Level::Debug);
$handlerNarrative->setFormatter(new ColoredLineFormatter(null, $output, $dateFormat));
$narrativeLog->pushHandler($handlerNarrative);

/**
 * SET UP ROUTING
 */
$router = new \Bramus\Router\Router();

// Clients
$router->post('/client/', function () {
    global $logger;
    $logger->debug("Register client", ["REMOTE_ADDR", $_SERVER['REMOTE_ADDR'], "ID", $_POST["id"]]);
    try {
        // default to setting the IP to the callers IP, but if it is explicitly supplied use that instead
        if (!isset($_POST["ip"])) {
            $_POST["ip"] = $_SERVER['REMOTE_ADDR'];
        }
        $client = new Acheron\Client(@$_POST["id"], @$_POST["ip"]);
        Acheron\Output::json((array)$client);
    } catch (Exception $e) {
        Acheron\Output::error($e, 500);
        $logger->warning($e->getMessage(), ["REMOTE_ADDR", $_SERVER['REMOTE_ADDR']]);
    }
});
$router->get('/clients', function () {
    $clients = Acheron\Client::getAll();
    Acheron\Output::json($clients);
});
$router->get('/clients/aggregated', function () {
    $clients = Acheron\Client::getAll(true);
    Acheron\Output::json($clients);
});


// SIGNALS
$router->get('/signals/', function () {
    $signals = Acheron\Signal::getAll();
    Acheron\Output::json($signals);
});

$router->get('/signals/(\d+)', function ($id) {
    $signal = Acheron\Signal::getById($id);
    Acheron\Output::json($signal);
});

// EMITTER TYPES
$router->get('/emitters/', function () {
    $emitters = Acheron\EmitterType::getAll(false);
    Acheron\Output::json($emitters);
});
$router->get('/emitters/all', function () {
    $emitters = Acheron\EmitterType::getAll(true);
    Acheron\Output::json($emitters);
});


// SENSORS
$router->get('/sensors/', function () {
    Acheron\Output::json(Acheron\Sensor::getAll());
});

$router->get('/sensors/(\d+)', function ($id) {
    Acheron\Output::json((array)Acheron\Sensor::getById($id));
});

// BIOMONITOR
$router->get('/biomonitor/', function () {
    Acheron\Output::json((array)Acheron\Biomonitor::getAll());
});


// DEBUGGING/TESTING
$router->get('/test', function () {
    print_r(Acheron\Biomonitor::getAll());
});

// ALERT STATE
$router->get('/alert', function () {
    $db = new DB();
    $state = $db->get("SELECT * FROM alert_state  ORDER BY time_set DESC LIMIT 1");
    Acheron\Output::json($state[0]);
});


$router->run();
