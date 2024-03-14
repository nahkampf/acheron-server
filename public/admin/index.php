<?php
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
        case "emitters":
            break;
        case "clients":
            require "clients.php";
            break;
        default:
            require "dashboard.php";
            break;
    }
?>
</div>