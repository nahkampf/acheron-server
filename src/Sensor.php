<?php

namespace Acheron;

use Acheron\DB;

class Sensor
{
    public $id;
    public $name;
    public $lng;
    public $lat;
    public $status;
    public $battery;

    public static function getById()
    {
    }

    public static function getAll()
    {
        $db = new DB();
    }
}
