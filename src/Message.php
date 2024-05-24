<?php

namespace Acheron;

use Acheron\DB as DB;

class Message
{

    public $cleartextMessage;
    public $encryptedMessage;
    public $decryptedMessage;
    public $decryptedTimestamp;

    public function __construct()
    {

    }

    public function encryptMessage(array $phrases)
    {
        foreach ($phrases as $idx => $phrase) {
            print_r($phrase);
        }
    }

    public function getMessage($id) {
        $db = new DB();
        $sql = "SELECT * FROM messages WHERE id=" . (int)$id;
        $res = $db->get($sql);
        return $res[0];
    }
}