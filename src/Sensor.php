<?php

namespace Acheron;

use Acheron\DB;

class Sensor
{
    public function __construct(
        public int $id,
        public string $name,
        public float $lng,
        public float $lat,
        public string $status,
        public $battery = null
    ) {}

    public static function getById(int $id): Sensor
    {
        $db = new DB();
        $sql = "SELECT  id, 
                        name, 
                        lat, 
                        lng, 
                        battery_level as battery, 
                        status
                        FROM sensors
                        WHERE id = " . (int)$id;
        $result = $db->get($sql)[0];
        return new Sensor(...$result);
    }

    public static function getAll(): array
    {
        $db = new DB();
        $sql = "SELECT id, name, lat, lng, battery_level as battery, status FROM sensors ORDER BY name DESC";
        $result = $db->get($sql);
        foreach ($result as $sensor) {
            $sensors[] = new Sensor(...$sensor);
        }
        return $sensors;
    }
}
