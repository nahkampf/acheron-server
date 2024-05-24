<?php
ob_start();
require "../../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

require "_header.php";
require "_menu.php";
?>
<div id="main">
    <?php
    // handle pages
    switch (@$_GET["page"]) {
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