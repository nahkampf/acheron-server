<?php

namespace Acheron;

use Acheron\Exceptions\InvalidClientException;
use Acheron\DB;

class Client
{
    public $id;
    public $ip;
    public $last_report;

    public function __construct(string $id, string $ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            $this->register($id, $ip);
        } else {
            throw new InvalidClientException("Client ip not valid: {$ip}");
        }
    }

    public function register($id, $ip)
    {
        $db = new DB();
        $sql = "INSERT INTO clients SET id=\"" . $db->e($id) . "\", ip=\"" . $db->e($ip) . "\" ON DUPLICATE KEY UPDATE id=\"" . $db->e($id) . "\", ip=\"" . $db->e($ip) . "\", last_report = NOW()";
        if ($db->query($sql)) {
            $this->id = $id;
            $this->ip = $ip;
            $res = $db->get("SELECT NOW() AS time");
            $this->last_report = $res[0]["time"];
        } else {
            throw InvalidClientException();
        }
    }

    public static function get($id, $ip)
    {
    }

    public static function getAll()
    {
        $db = new DB();
        $res = $db->get("SELECT * FROM clients ORDER BY last_report DESC");
        return $res;
    }
}
