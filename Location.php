<?php
include_once('DbLayer.php');
class Location {
    var $latitude;
    var $longitude;
    var $name;
    var $address;
    var $description;
    var $type;
    var $lastUpdateTime;
    public function __construct($latitude, $longitude, $name, $address, $description, $type, $lastUpdateTime) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->name = $name;
        $this->address = $address;
        $this->description = $description;
        $this->type = $type;
        $this->lastUpdateTime = $lastUpdateTime;
    }
}

class LocationsContract {
    /**
     * Locations Table
     */
    const LOCATIONS_TABLE_NAME = "locations";
    const LOCATIONS_COLUMN_ID = "id";
    const LOCATIONS_COLUMN_LATITUTDE = "latitude";
    const LOCATIONS_COLUMN_LONGITUDE = "longitude";
    const LOCATIONS_COLUMN_NAME = "name";
    const LOCATIONS_COLUMN_TYPE = "type";
    const LOCATIONS_COLUMN_ADDRESS = "address";
    const LOCATIONS_COLUMN_OTHER = "other";
    const LOCATIONS_COLUMN_LAST_UPDATED = "lastupdated";

    const TYPE_ADAPTADAS = "adaptadas";
    const TYPE_ASAMBLEA = "asamblea";
    const TYPE_BRAVO = "bravo";
    const TYPE_CUAP = "cuap";
    const TYPE_HOSPITAL = "hospital";
    const TYPE_MARITIMO = "maritimo";
    const TYPE_NOSTRUM = "nostrum";
    const TYPE_SOCIAL = "social";
    const TYPE_TERRESTRE = "terrestre";
}