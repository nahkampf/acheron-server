<?php

namespace Acheron;

class Output
{
    public static function json(array $data, $http_code = 200)
    {
        header("Content-type: application/json;");
        http_response_code($http_code);
        echo json_encode($data);
    }

    public static function raw($data, $preformatted = true, $http_code = 200)
    {
        http_response_code($http_code);
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

    public static function error($data, $http_code = 500)
    {
        if (is_a($data, "Exception")) {
            self::json(["error" => $data->getMessage()], 500);
            return;
        }
        if (!is_array($data)) {
            $data = ["error" => $data];
        }
        self::json($data, 200);
    }
}
