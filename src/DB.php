<?php

namespace Acheron;

class DB
{
    private $db;

    public function __construct()
    {
        $this->db = new \mysqli($_ENV["DB_HOST"], $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], $_ENV["DB_DATABASE"], $_ENV["DB_PORT"]);
        $this->db->query("SET NAMES utf8");
    }

    public function query($sql)
    {
        return $this->db->query($sql);
    }

    // escape
    public function e($sql)
    {
        return $this->db->real_escape_string($sql);
    }

    public function get($sql)
    {
        return $this->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function id()
    {
        return $db->insert_id();
    }
}
