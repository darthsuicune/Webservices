<?php

include_once('DbLayer.php');
include_once('Location.php');
class LocationsService {
    public function getLocations($user, $lastUpdateTime) {
        if($user == null){
            return null;
        }
        return $this->getLocationList($user, $lastUpdateTime);
    }

    function getLocationList($user, $lastUpdateTime){
        if($user == null){
            return null;
        }
        $dbLayer = new DbLayer();
        if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_ERROR) {
            return null;
        }

        if($lastUpdateTime == null){
            $lastUpdateTime = 0;
        }
        $projection = array(
            LocationsContract::LOCATIONS_COLUMN_LATITUDE,
            LocationsContract::LOCATIONS_COLUMN_LONGITUDE,
            LocationsContract::LOCATIONS_COLUMN_NAME,
            LocationsContract::LOCATIONS_COLUMN_TYPE,
            LocationsContract::LOCATIONS_COLUMN_ADDRESS,
            LocationsContract::LOCATIONS_COLUMN_OTHER,
            LocationsContract::LOCATIONS_COLUMN_LAST_UPDATED,
        	LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE
        );
        $tables = array(LocationsContract::LOCATIONS_TABLE_NAME);
        $where = LocationsContract::LOCATIONS_COLUMN_LAST_UPDATED . ">% AND " .
		LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE . ">% AND " . 
        LocationsContract::LOCATIONS_COLUMN_TYPE . " IN (%)";
        $whereargs = array(
            $lastUpdateTime,
        	round(microtime(true) * 1000),
            $user->getAllowedTypes()
        );

        $result = $dbLayer->query($projection, $tables, $where, $whereargs);

        if($result == null){
            return null;
        }
        $locationList = array();
        while ($row = $result->fetch_assoc()) {
            $locationList[] = new Location($row);
        }

        $dbLayer->close();
        return $locationList;
    }
}