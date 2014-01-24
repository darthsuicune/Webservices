<?php

include_once('DbLayer.php');
include_once('Location.php');
class LocationsService {
    public function getLocations($user, $lastUpdateTime) {
        if($user == null){
            return null;
        }
        $where = LocationsContract::LOCATIONS_COLUMN_LAST_UPDATED . ">% AND " .
        		"(" . LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE . ">% OR " .
        		LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE . " =0" . ") AND " .
        		LocationsContract::LOCATIONS_COLUMN_TYPE . " IN (%)";
        $whereArgs = array(
        		$lastUpdateTime,
        		round(microtime(true) * 1000),
        		$user->getAllowedTypes()
        );
        return $this->getLocationsFromDb($user, $lastUpdateTime, $where, $whereArgs);
    }
    
    public function  getWebLocations($user) {
    	$where = LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE . ">% OR " .
    			LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE . "=0";
    	$whereArgs = array (
    			round(microtime(true) * 1000)
    	);
    	return $this->getLocationsFromDb($user, 0, $where, $whereArgs);
    	 
    }
    
    public function getAdminLocations($user) {
    	$where = LocationsContract::LOCATIONS_COLUMN_TYPE . " IN (%)";
    	$whereArgs = array(
    			$user->getAllowedTypes()
    	);
    	return $this->getLocationsFromDb($user, 0, $where, $whereArgs);
    }

    function getLocationList($user, $lastUpdateTime){
    	
    	 
    }
    
    function getLocationsFromDb($user, $lastUpdateTime, $where, array $whereArgs){
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
    			LocationsContract::LOCATIONS_COLUMN_ID,
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
    	
    	$result = $dbLayer->query($projection, $tables, $where, $whereArgs);
    	
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
    public static function addLocation(array $values){
    	$dbLayer = new DbLayer(DbLayer::DB_ADDRESS, User::DB_INSERT_USER, User::DB_INSERT_PASS, DbLayer::DB_DATABASE);
    	if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_ERROR) {
    		return null;
    	}
    	$dbLayer->insert(LocationsContract::LOCATIONS_TABLE_NAME, $values);
    	$dbLayer->close();
    }
    
    public static function deleteLocation($id){
    	$dbLayer = new DbLayer(DbLayer::DB_ADDRESS, User::DB_INSERT_USER, User::DB_INSERT_PASS, DbLayer::DB_DATABASE);
    	if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_ERROR) {
    		return null;
    	}
    	$where = LocationsContract::LOCATIONS_COLUMN_ID . "=%";
    	$whereArgs = array($id);
    	$dbLayer->delete(LocationsContract::LOCATIONS_TABLE_NAME, 
    			$where, $whereArgs);
    	$dbLayer->close();
    }
    
    public static function updateLocation($id, array $values){
    	$dbLayer = new DbLayer(DbLayer::DB_ADDRESS, User::DB_INSERT_USER, User::DB_INSERT_PASS, DbLayer::DB_DATABASE);
    	if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_ERROR) {
    		return null;
    	}
    	$where = LocationsContract::LOCATIONS_COLUMN_ID . "=%";
    	$whereArgs = array($id);
    	$dbLayer->update($values, LocationsContract::LOCATIONS_TABLE_NAME, 
    			$where, $whereArgs);
    	$dbLayer->close();
    }
}