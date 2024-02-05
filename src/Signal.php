<?php

namespace Acheron;

class Signal
{
    public $id;
    public $lat;
    public $lng;
    public $timestamp;
    public $type;
    public $velocity;

    public function __construct(array $signaldata)
    {
        $this->id = $signaldata["id"];
        $this->lat = $signaldata["latitude"];
        $this->lng = $signaldata["longitude"];
        $this->timestamp = $signaldata["timestamp"];
        $this->type = $signaldata["type"];
        $this->velocity = $signaldata["velocity"];
        return $this;
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
