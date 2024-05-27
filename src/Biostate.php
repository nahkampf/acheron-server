<?php

namespace Acheron;

use Acheron\DB;

class Biostate
{
    public function __construct(
        public int $id,
        public string $name,
        public int $pulse_low,
        public int $pulse_high,
        public int $spo2_low,
        public int $spo2_high,
        public int $bp_low,
        public int $bp_high,
        public string $color
    ) {}

    public static function getById(int $id): Biostate
    {
        $db = new DB();
        $result = $db->get("SELECT * FROM biomonitor_modes WHERE id=" . (int)$id);
        return new Biostate(...$result[0]);
    }

    public static function getAll(): array
    {
        $db = new DB();
        $result = $db->get("SELECT * FROM biomonitor_modes ORDER BY name ASC");
        foreach ($result as $state) {
            $states[] = new Biostate(...$state);
        }
        return $states;
    }
}
