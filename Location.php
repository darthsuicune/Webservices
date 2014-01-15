<?php
class Location {
    var $latitude;
    var $longitude;
    var $name;
    var $type;
    var $address;
    var $other;
    var $lastUpdateTime;
    var $expireDate;
    /**
     * Public constructor
     * @param mysql_assoc $row mysql row containing the relative data.
     */
    public function __construct ( $row ) {
        $this->latitude = $row[LocationsContract::LOCATIONS_COLUMN_LATITUDE];
        $this->longitude = $row[LocationsContract::LOCATIONS_COLUMN_LONGITUDE];
        $this->name = $row[LocationsContract::LOCATIONS_COLUMN_NAME];
        $this->type = $row[LocationsContract::LOCATIONS_COLUMN_TYPE];
        $this->address = $row[LocationsContract::LOCATIONS_COLUMN_ADDRESS];
        $this->other = $row[LocationsContract::LOCATIONS_COLUMN_OTHER];
        $this->lastUpdateTime = $row[LocationsContract::LOCATIONS_COLUMN_LAST_UPDATED];
        $this->expireDate = $row[LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE];
    }
}

class LocationsContract {
    /**
     * Locations Table
     */
    const LOCATIONS_TABLE_NAME = "locations";
    const LOCATIONS_COLUMN_ID = "id";
    const LOCATIONS_COLUMN_LATITUDE = "latitude";
    const LOCATIONS_COLUMN_LONGITUDE = "longitude";
    const LOCATIONS_COLUMN_NAME = "name";
    const LOCATIONS_COLUMN_TYPE = "type";
    const LOCATIONS_COLUMN_ADDRESS = "address";
    const LOCATIONS_COLUMN_OTHER = "other";
    const LOCATIONS_COLUMN_LAST_UPDATED = "lastupdated";
    const LOCATIONS_COLUMN_EXPIRE_DATE = "expiredate";

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