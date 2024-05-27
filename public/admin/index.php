<?php
ob_start();
require "../../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();


// SET UP LOGGING
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\ErrorHandler;
use Monolog\Formatter\LineFormatter;
use Bramus\Monolog\Formatter\ColoredLineFormatter;
$dateFormat = "Y-m-d H:i:s";
$output = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
$logger = new Logger('acheron_admin_full');
$handler = new StreamHandler(__DIR__ . '/../../logs/admin.log', Level::Debug);
$handler->setFormatter(new ColoredLineFormatter(null, $output, $dateFormat));
$logger->pushHandler($handler);
ErrorHandler::register($logger); // log all errors and exceptions to the logfile

$narrativeLog = new Logger('acheron_narrative');
$handlerNarrative = new StreamHandler(__DIR__ . '/../../logs/narrative.log', Level::Debug);
$handlerNarrative->setFormatter(new ColoredLineFormatter(null, $output, $dateFormat));
$narrativeLog->pushHandler($handlerNarrative);

require "_header.php";
require "_menu.php";
?>
<div id="main">
    <?php
    // handle pages
    switch (@$_GET["page"]) {
        case "alerts":
            require "alerts.php";
            break;
        case "signals":
            require "signals.php";
            break;
        case "emitters":
            require "emitters.php";
            break;
        case "clients":
            require "clients.php";
            break;
        case "messages":
            require "messages.php";
            break;
        default:
            require "dashboard.php";
            break;
    }
?>
</div>