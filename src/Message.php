<?php

namespace Acheron;

use Acheron\DB as DB;

class Message
{
    public static function getMessage($id) {
        $db = new DB();
        $sql = "SELECT * FROM messages WHERE id=" . (int)$id;
        $res = $db->get($sql);
        return (@$res[0]) ? : null;
    }

    public static function setDecipheredMessage($id, $message) {
        $db = new DB();
        $sql = "UPDATE signals SET message=\"".$db->e($message)."\" WHERE id=".(int)$id;
        $res = $db->get($sql);
    }
}