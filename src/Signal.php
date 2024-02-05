<?php

namespace Acheron;

use Acheron\DB as DB;

class Signal
{
    public $id;
    public $interceptTime = null;
    public $lat;
    public $lng;
    public $timestamp;
    public $type;
    public $velocity;

    /**
     * Signals cannot be instantiated outside of this class!
     * ie no new Signal(), the objects can only be created via the static getters
     */
    private function __construct(?array $signaldata)
    {
        if (!empty($signaldata)) {
            $this->id = $signaldata["id"];
            $this->lat = $signaldata["latitude"];
            $this->lng = $signaldata["longitude"];
            $this->timestamp = $signaldata["timestamp"];
            $this->type = $signaldata["type"];
            $this->velocity = $signaldata["velocity"];
        }
    }

    public static function getAll()
    {
        $db = new DB();
        $sigs = $db->get("SELECT * FROM map ORDER BY timestamp DESC");
        foreach ($sigs as $key => $signal) {
            $signals[$signal["id"]] = new Signal($signal);
        }
        return $signals;
    }

    public static function getById($id)
    {
        $db = new DB();
        $signal = $db->get("SELECT * FROM map WHERE id = " . (int)$id);
        return new Signal($signal);
    }
}
