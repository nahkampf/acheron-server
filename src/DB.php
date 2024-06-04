<?php

namespace Acheron;

class DB
{
    private $db;

    public function __construct()
    {
        $this->db = new \mysqli(
            $_ENV["DB_HOST"],
            $_ENV["DB_USER"],
            $_ENV["DB_PASSWORD"],
            $_ENV["DB_DATABASE"],
            $_ENV["DB_PORT"]
        );
        $this->db->query("SET NAMES utf8");
        // allow grouping on non-keyed columns ("lax mode")
        $this->db->query(
            "SET SESSION sql_mode = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';"
        );
        $this->db->query(
            "SET GLOBAL sql_mode = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';"
        );
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
        return $this->db->insert_id();
    }

    public function getNow()
    {
        return $this->db->query("SELECT NOW() as time")->fetch_all(MYSQLI_ASSOC)[0]["time"];
    }
}
