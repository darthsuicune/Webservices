<?php

include_once('DbLayer.php');
include_once('Location.php');
class LocationsService {
    public function getLocations($user, $lastUpdateTime) {
        if($user == null){
            return null;
        }
        $where = LocationsContract::LOCATIONS_COLUMN_LAST_UPDATED . ">?";
        $whereArgs = array($lastUpdateTime);
        
        return $this->getLocationsFromDb($user, $where, $whereArgs);
    }
    
    public function getWebLocations($user) {
    	if($user == null){
    		return null;
    	}
    	
    	$where = "(" . LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE . "=0 OR " . 
    			LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE . ">?) AND " .
    			LocationsContract::LOCATIONS_COLUMN_ACTIVE . "=1";
    	$whereArgs = array(round(microtime(true)* 1000));
    	
    	return $this->getLocationsFromDb($user, $where, $whereArgs);
    }
    
    function getLocationsFromDb($user, $where, array $whereArgs){
    	if($user == null){
    		return null;
    	}
    	$dbLayer = new DbLayer();
    	if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_ERROR) {
    		return null;
    	}
    	$projection = array(
    			LocationsContract::LOCATIONS_COLUMN_ID,
    			LocationsContract::LOCATIONS_COLUMN_LATITUDE,
    			LocationsContract::LOCATIONS_COLUMN_LONGITUDE,
    			LocationsContract::LOCATIONS_COLUMN_NAME,
    			LocationsContract::LOCATIONS_COLUMN_TYPE,
    			LocationsContract::LOCATIONS_COLUMN_ADDRESS,
    			LocationsContract::LOCATIONS_COLUMN_OTHER,
    			LocationsContract::LOCATIONS_COLUMN_PHONE,
    			LocationsContract::LOCATIONS_COLUMN_ACTIVE,
    			LocationsContract::LOCATIONS_COLUMN_LAST_UPDATED,
    			LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE
    	);
    	$table = LocationsContract::LOCATIONS_TABLE_NAME;
    	
    	$result = $dbLayer->query($projection, $table, $where, $whereArgs);
    	if(!is_array($result) || $result == null){
    		return null;
    	}
    	$locationList = array();
    	foreach ($result as $value) {
    		$locationList[] = new Location($value);
    	}
    	
    	return $locationList;
    }
    public static function addLocation(array $values){
    	$dbLayer = new DbLayer();
    	if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_ERROR) {
    		return null;
    	}
    	$dbLayer->insert(LocationsContract::LOCATIONS_TABLE_NAME, $values);
    }
    
    public static function deleteLocation($id){
    	$dbLayer = new DbLayer();
    	if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_ERROR) {
    		return false;
    	}
    	$values = array(
    			LocationsContract::LOCATIONS_COLUMN_LAST_UPDATED=>round(microtime(true) * 1000),
    			LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE=>"1");
    	$where = LocationsContract::LOCATIONS_COLUMN_ID . "=?";
    	$whereArgs = array($id);
    	$dbLayer->update($values, LocationsContract::LOCATIONS_TABLE_NAME, $where, $whereArgs);
    }
    
    public static function updateLocation($id, array $values){
    	$dbLayer = new DbLayer();
    	if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_ERROR) {
    		return null;
    	}
    	$where = LocationsContract::LOCATIONS_COLUMN_ID . "=?";
    	$whereArgs = array($id);
    	$dbLayer->update($values, LocationsContract::LOCATIONS_TABLE_NAME, 
    			$where, $whereArgs);
    }
}
