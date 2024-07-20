<?php

namespace Acheron;

use Acheron\DB;

class Surfops
{
    public function __construct(
        public int $id,
        public string $rank,
        public string $name,
        public ?string $portrait
    ) {}

    public static function getAll(): array
    {
        $db = new DB();
        $result = $db->get("SELECT * FROM surfops_people ORDER BY id ASC");
        foreach ($result as $surfer) {
            $surfers[] = new Surfops(...$surfer);
        }
        return $surfers;
    }

    public static function getById($id): Surfops
    {
        $db = new DB();
        return $db->get("SELECT * FROM surfops_people WHERE id = " . (int)$id)[0];
    }

    public static function getPositions($all = false) {
        $db = new DB();
        if ($all) {
            $sql = "SELECT * FROM surfops_positions ORDER BY `timestamp` DESC";
        } else {
            $sql = "SELECT * FROM surfops_positions ORDER BY `timestamp` DESC LIMIT 5";
        }
        $ret = $db->get($sql);
        foreach($ret as $idx => $pos) {
            $nearest = self::determineNearestSensors($pos["latitude"], $pos["longitude"]);
            $primary = Geo::getBearing(
                $nearest[0]["lng"],
                $nearest[0]["lat"],
                $pos["latitude"],
                $pos["longitude"]
            );
            $secondary = Geo::getBearing(
                $nearest[1]["lng"],
                $nearest[1]["lat"],
                $pos["latitude"],
                $pos["longitude"]
            );
            $ret[$idx]["primary_sensor"] = $nearest[0];
            $ret[$idx]["primary_sensor"] = array_merge($ret[$idx]["primary_sensor"], $primary);
            $ret[$idx]["secondary_sensor"] = $nearest[1];
            $ret[$idx]["secondary_sensor"] = array_merge($ret[$idx]["secondary_sensor"], $secondary);
        }
        return $ret;
    }
    /**
     * Determines the two nearest (online) sensors to the signal being emitted.
     * This is to set "primary" and "secondary" sensors for a signal, which in turn
     * is used to calculate bearings etc.
     *
     * @return array An array containing the primary and the secondary sensor nearest the signal
     */
    public static function determineNearestSensors($lat, $lng)
    {
        $db = new DB();
        $sensors = $db->get("SELECT * FROM sensors WHERE status=\"online\"");
        foreach ($sensors as $idx => $sensor) {
            // calculate a distance between this sensor and the signal coordinates
            //print_r($sensor);
            //echo $sensor["lat"] . " - " . $sensor["lng"] . " -> " . $lng . " , " . $lat;
            $distance = Geo::getDistance($sensor["lat"], $sensor["lng"], $lng, $lat);
            $sensors[$idx]["distance"] = $distance;
        }
        // ugly hack to only get the two closest sensors
        foreach ($sensors as $idx => $sensor) {
            $sorted[(int)$sensor["distance"]] = $sensor;
        }
        ksort($sorted);
        $x = 0;
        //print_r($sorted);
        foreach ($sorted as $sensor) {
            //print_r($sensor);
            switch ($x) {
                case 0:
                    $nearest[0] = $sensor;
                    break;
                case 1:
                    $nearest[1] = $sensor;
                    break;
                default:
                    break(2); // break out of the foreach
            }
            $x++;
        }
        //print_R($nearest);
        return $nearest;
    }
}
