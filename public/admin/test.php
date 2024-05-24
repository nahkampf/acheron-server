<?php
require "../../vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../../");
$dotenv->load();

use Acheron\DB;
use Acheron\CP437;

// generate "ascii" table
$table = CP437::generateAsciiTable();
echo "<pre>";
foreach ($table as $key => $val) {
    echo $key ." " . $val["utf8char"]."\n";
}

die();

$db = new DB();
$sql = "SELECT * FROM message_corpus WHERE id=5";
$phrase = $db->get($sql)[0];

print_r($phrase);

$encoded = CP437::encode($phrase["sequence"]);
print_r($encoded);
