<?php

namespace Acheron;

use Location\Bearing\BearingSpherical;
use Location\Coordinate;
use Location\Distance\Vincenty;

class Geo
{
    public $source_x;
    public $source_y;
    public $target_x;
    public $target_y;
    public $bearing_from_target;
    public $bearing_from_source;
    public $distance;

    public function __construct(float $source_x, float $source_y, float $target_x, float $target_y)
    {
        $bearing = self::getBearing($source_x, $source_y, $target_x, $target_y);
        $this->source_x = $source_x;
        $this->source_y = $source_y;
        $this->target_x = $target_x;
        $this->target_y = $target_y;
        $this->bearing_from_source = $bearing["bearing_from_source"];
        $this->bearing_from_target = $bearing["bearing_from_target"];
        $this->distance = self::getDistance($source_x, $source_y, $target_x, $target_y);
    }

    public static function getBearing(float $source_x, float $source_y, float $target_x, float $target_y): array
    {
        $source = new Coordinate($source_x, $source_y);
        $target = new Coordinate($target_x, $target_y);

        // spherical earth model is very fast, but less reliable, but should not be an issue here
        // elliptical is more precise, but slower
        $bearingCalculator = new BearingSpherical();
        $data["bearing_from_source"] = floor($bearingCalculator->calculateBearing($source, $target));
        $data["bearing_from_target"] = floor($bearingCalculator->calculateBearing($target, $source));
        return $data;
    }

    public static function getDistance(float $source_x, float $source_y, float $target_x, float $target_y): float
    {
        $source = new Coordinate($source_x, $source_y);
        $target = new Coordinate($target_x, $target_y);
        // Vincenty is slow but precise, Haversine is fast but imprecise.
        $calculator = new Vincenty();
        return $calculator->getDistance($source, $target); // returns in Meters
    }
}
