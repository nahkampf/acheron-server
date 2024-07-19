<?php

namespace Acheron;

use Acheron\DB;

class Alert
{
    public static function get()
    {
        $db = new DB();
        $state = $db->get("SELECT * FROM alert_state ORDER BY time_set DESC LIMIT 1");
        return $state[0];
    }

    public static function set($state = "green")
    {
        // first, get current (for logging purposes)
        $current = self::get();
        switch (strtolower($state)) {
            case "red":
                $state = "red";
                break;
            case "blue":
                $state = "blue";
                break;
            case "green":
                $state = "green";
                break;
            default:
                $state = "red";
                break;
        }
        $db = new DB();
        // wipe everything first
        $db->query(
            "DELETE FROM alert_state"
        );
        $db->query("INSERT INTO alert_state SET current_state = \"" . $state . "\"");
    }

}