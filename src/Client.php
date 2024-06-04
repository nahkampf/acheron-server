<?php

namespace Acheron;

use Acheron\Exceptions\InvalidClientException as InvalidClientException;
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
        $sql = "INSERT INTO clients SET id=\"" .
            $db->e($id) .
            "\", ip=\"" .
            $db->e($ip) .
            "\" ON DUPLICATE KEY UPDATE id=\"" .
            $db->e($id) .
            "\", ip=\"" .
            $db->e($ip) .
            "\", last_report = NOW()";
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

    public static function getAll($aggregated = false)
    {
        $db = new DB();
        $sql = ($aggregated)
        ? "SELECT id, ip, MAX(last_report) AS last_report FROM clients GROUP BY id ORDER BY last_report DESC"
        : "SELECT * FROM clients ORDER BY last_report DESC";
        $res = $db->get($sql);
        return $res;
    }
}
