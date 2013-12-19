<?php

include_once('DbLayer.php');
class LocationsService {
    public function getLocations($user, $lastUpdateTime) {
        if($user == null){
            return null;
        }
        return $this->getLocationList($user, $lastUpdateTime);
    }

    function getLocationList($user, $lastUpdateTime){
        $dbLayer = new DbLayer();
        if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_ERROR) {
            return null;
        }
        $locationList;
        
        $dbLayer->close();
        return $locationList;
    }
}