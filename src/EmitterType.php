<?php

namespace Acheron;

use Acheron\DB as DB;

class EmitterType
{
    public $id;

    private function __construct()
    {
    }

    public static function getAll()
    {
        $db = new DB();
        $sql = "SELECT * FROM emitter_types ORDER BY name ASC";
        $res = $db->get($sql);
        return $res;
    }

    public static function getById(int $id)
    {
        $db = new DB();
        $sql = "SELECT * FROM emitter_types WHERE id = " . (int)$id;
        $res = $db->get($sql);
        return $res;
    }

    public static function getNextAvailableNumber() {
        $db = new DB();
        $sql = "SELECT `number` FROM emitter_types ORDER BY `number` DESC LIMIT 1";
        $res = $db->get($sql);
        $number = intval(str_replace("XM", "", $res[0]["number"]));
        $number++;
        return sprintf('%02d', $number);
    }
}