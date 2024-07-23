<?php

namespace Acheron;

use Acheron\DB as DB;
use Acheron\Geo as Geo;
use Acheron\Message;

class Signal
{
    public $id;
    public $interceptTime = null;
    public $lat;
    public $lng;
    public $timestamp;
    public $emitter;
    public $velocity;
    public $heading;
    public $primary_sensor;
    public $secondary_sensor;
    public $designation;
    public $designated_type;
    public $handled;
    public $interceptingOperator;
    public $decipheredMessage;
    public $encryptedMessage;

    /**
     * Signals cannot be instantiated outside of this class!
     * ie no new Signal(), the objects can only be created via the static getters
     */
    private function __construct(?array $signaldata)
    {
        if (!empty($signaldata)) {
            $this->id = $signaldata["id"];
            $this->lat = $signaldata["lat"];
            $this->lng = $signaldata["lng"];
            $this->timestamp = $signaldata["timestamp"];
            $this->emitter = $signaldata["emitter"];
            $this->velocity = $signaldata["velocity"];
            $this->heading = $signaldata["heading"];
            $this->interceptTime = $signaldata["intercepted"];
            $this->designation = $signaldata["designation"];
            $this->designated_type = $signaldata["designated_type"];
            $this->determineNearestSensors();
            // set bearings
            $this->primary_sensor["bearings"] = Geo::getBearing(
                $this->primary_sensor["lat"],
                $this->primary_sensor["lng"],
                $this->lat,
                $this->lng
            );
            $this->secondary_sensor["bearings"] = Geo::getBearing(
                $this->secondary_sensor["lat"],
                $this->secondary_sensor["lng"],
                $this->lat,
                $this->lng
            );
            $this->handled = $signaldata["handled"];
            $this->interceptingOperator = $signaldata["intercepting_operator"];
            $this->decipheredMessage = $signaldata["message"];
            $this->encryptedMessage = (Message::getMessage($signaldata["encrypted_message"])) ?: null;
        }
    }

    public static function getAll()
    {
        $db = new DB();
        $sigs = $db->get("SELECT * FROM signals ORDER BY `timestamp` DESC");
        foreach ($sigs as $key => $signal) {
            $signals[$signal["id"]] = new Signal($signal);
        }
        return $signals;
    }

    public static function getById($id)
    {
        $db = new DB();
        $sql = "SELECT * FROM signals WHERE id = " . (int)$id;
        $signal = $db->get($sql);
        return (array)new Signal($signal[0]);
    }

    public function setReceived()
    {
        $this->interceptTime = date("Y-m-d H:i:s");
    }

    /**
     * Determines the two nearest (online) sensors to the signal being emitted.
     * This is to set "primary" and "secondary" sensors for a signal, which in turn
     * is used to calculate bearings etc.
     *
     * @return array An array containing the primary and the secondary sensor nearest the signal
     */
    public function determineNearestSensors()
    {
        $db = new DB();
        $sensors = $db->get("SELECT * FROM sensors WHERE status=\"online\"");
        foreach ($sensors as $idx => $sensor) {
            // calculate a distance between this sensor and the signal coordinates
            $distance = Geo::getDistance($sensor["lat"], $sensor["lng"], $this->lat, $this->lng);
            $sensors[$idx]["distance"] = $distance;
        }
        // ugly hack to only get the two closest sensors
        foreach ($sensors as $idx => $sensor) {
            $sorted[(int)$sensor["distance"]] = $sensor;
        }
        ksort($sorted);
        $x = 0;
        foreach ($sorted as $sensor) {
            switch ($x) {
                case 0:
                    $this->primary_sensor = $sensor;
                    break;
                case 1:
                    $this->secondary_sensor = $sensor;
                    break;
                default:
                    break(2); // break out of the foreach
            }
            $x++;
        }
        return $sensors;
    }

    public static function getNextDesignation() {
        $db = new DB();
        $sql = "SELECT MAX(designation) AS highest, SUBSTRING(designation, 1,1) AS prefix,MAX(SUBSTRING(designation, 2,1)) AS val, SUBSTRING(designation, 1,1) AS prefix FROM signals GROUP BY prefix ORDER BY highest DESC";
        // determine what the next designation should be
        // (the prefix with the lowst count, then add 1)
        $res = $db->get($sql);
        $prefixes =["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "X", "Y", "Z"];
        if (!ctype_alpha(@(string)$res[0]["prefix"])) {
            $res[0]["prefix"] = "A";
            $res[0]["val"] = 0;
        }
        if ($res[0]["val"] > 9) {
            $idx = array_search($res[0]["prefix"], $prefixes) + 1;
            $res[0]["prefix"] = $prefixes[$idx];
            $res[0]["val"] = 0;
        }
        return [$res[0]["prefix"] . ($res[0]["val"] + 1)];
    }

    public static function updateSignal(int $id, array $keyvals) {
        $db = new DB();
        foreach ($keyvals as $key => $val) {
            // special case, handle NOW()
            if ($val == "NOW()") {
                $sql = "UPDATE signals SET " . $key ." = NOW() WHERE id=" . $id ." LIMIT 1";
            } else {
                $sql = "UPDATE signals SET " . $key ." = \"" . $db->e($val). "\" WHERE id=" . $id ." LIMIT 1";
            }
            $db->query($sql);
        }
    }
}
