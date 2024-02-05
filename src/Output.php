<?php

namespace Acheron;

class Output
{
    public static function json(array $data)
    {
        header("Content-type: application/json;");
        echo json_encode($data);
    }

    public static function raw($data, $preformatted = true)
    {
        if ($preformatted) {
            echo "<pre>";
        }
        if (is_object($data) || is_array($data)) {
            print_r($data);
        } else {
            echo $data;
        }
        if ($preformatted) {
            echo "</pre>";
        }
    }
}
