<?php

namespace Acheron;

use Acheron\DB;
use Acheron\Biostate;
use Acheron\Surfops;

class Biomonitor
{
    public function __construct(
        public int $surferID,
        public Biostate $state
    ) {}

    public static function getBiomonitorForSurferID($id)
    {
        $db = new DB();
        $result = $db->get(
            "SELECT 
                biomonitor_states.*, 
                surfops_people.id, 
                surfops_people.rank, 
                surfops_people.name AS person_name, 
                surfops_people.portrait, 
                biomonitor_modes.* 
            FROM 
                biomonitor_states, 
                surfops_people, 
                biomonitor_modes 
            WHERE 
                biomonitor_modes.id = biomonitor_states.currentState 
            AND
                biomonitor_states.surferId = " . (int)$id . "
            AND
                surfops_people.id = biomonitor_states.surferId
            ORDER BY
                surfops_people.id"
        );
        return ($result) ? $result[0] : false;
    }

    public static function getAll(): array
    {
        $surfers = Surfops::getAll();
        foreach ($surfers as $key => $surfer) {
            $monitors[] = self::getBiomonitorForSurferID($surfer->id);
        }
        return $monitors;
    }
}
