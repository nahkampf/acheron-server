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

    public static function getById(): Surfops
    {
        $db = new DB();
        return $db->get("SELECT * FROM surfops_people WHERE id = " . (int)$id)[0];
    }
}
