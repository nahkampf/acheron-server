<?php

namespace Acheron;

use Acheron\DB;
use Acheron\Biostate;

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
                surfops_people.*, 
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
                surfops_people.id = biomonitor_states.surferId"
        );
        return ($result) ? $result[0] : false;
    }
}
