<?php
class Location {
    var $latitude;
    var $longitude;
    var $name;
    var $address;
    var $description;
    var $type;
    var $lastUpdateTime;
    public function __construct($latitude, $longitude, $name, $address, $description, $type,
            $lastUpdateTime) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->name = $name;
        $this->address = $address;
        $this->description = $description;
        $this->type = $type;
        $this->lastUpdateTime = $lastUpdateTime;
    }
}