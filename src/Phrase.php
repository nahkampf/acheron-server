<?php

namespace Acheron;

use Acheron\DB as DB;

class Phrase
{

    public $id;
    public $phrase;
    public $sequence;
    public $known;

    public function __construct()
    {
    }

    public static function getAll()
    {
        $db = new DB();
        $sql = "SELECT * FROM message_corpus ORDER BY phrase ASC";
        $res = $db->get($sql);
        $phrases = [];
        foreach ($res as $idx => $corpus) {
            $phrase = new Phrase();
            $phrase->id = $corpus["id"];
            $phrase->phrase = $corpus["phrase"];
            $phrase->sequence = $corpus["sequence"];
            $phrase->known = $corpus["known_to_players"];
            $phrases[] = $phrase;
        }
        return $phrases;
    }
}
