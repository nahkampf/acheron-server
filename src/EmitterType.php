<?php

namespace Acheron;

use Acheron\DB as DB;

class EmitterType
{
    public $id;

    private function __construct()
    {
    }

    public static function getAll(bool $all = false)
    {
        if ($all) {
            $vis = "";
        } else {
            $vis = "WHERE visible_to_players = \"Y\"";
        }
        $db = new DB();
        $sql = "SELECT * FROM emitter_types $vis ORDER BY number ASC";
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

    public static function sigintDrilldown($cws = 0, $cluster_start = false, $cluster_mid = false, $cluster_end = false) {
        $start = ($cluster_start) ? "Y" : "N";
        $mid = ($cluster_mid) ? "Y" : "N";
        $end = ($cluster_end) ? "Y" : "N";
        $and = "";
        $and .= " AND datacluster_start = '{$start}' ";
        $and .= " AND datacluster_middle = '{$mid}' ";
        $and .= " AND datacluster_end = '{$end}' ";
        $sql = "SELECT * FROM emitter_types WHERE number_of_cws = ". (int)$cws ." AND visible_to_players=\"Y\" " . $and . " ORDER BY number ASC";
        $db = new DB();
        return $db->get($sql);
    }

    public static function classify($signalId, $emitterId) {
        $db = new DB();
        $sql = "UPDATE signals SET designated_type = " . (int)$emitterId . ", handled=\"Y\" WHERE id=" . (int)$signalId;
        $db->query($sql);
    }
    public static function autoClassify($signalId) {
        $db = new DB();
        $sql = "UPDATE signals SET designated_type=emitter WHERE id=" . (int)$signalId;
        $db->query($sql);
    }
}
