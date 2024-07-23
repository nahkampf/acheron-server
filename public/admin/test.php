<?php
require "../../vendor/autoload.php";
use Acheron\CP437;

// generate "ascii" table
$table = CP437::generateAsciiTable();
echo "<pre>\n";
$x = 0;
foreach ($table as $key => $val) {
    echo $key . " " . $val["utf8char"];
    echo "\t";
    if ($x > 8) {
        $x = 0;
        echo "\n";
    }
}

die();

$db = new DB();
$sql = "SELECT * FROM message_corpus WHERE id=5";
$phrase = $db->get($sql)[0];

print_r($phrase);

$encoded = CP437::encode($phrase["sequence"]);
print_r($encoded);
