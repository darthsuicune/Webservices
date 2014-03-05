<?php
require_once('User.php');
require_once('LocationsContract.php');
class LocationsProviderImpl implements LocationsProvider {
	var	$dataStorage;
	public function __construct(DataStorage $dataStorage){
		$this->dataStorage = $dataStorage;
	}

	public function getLocationList(User $user, $lastUpdateTime = 0){
		$columns = array();
		$tables = array();
		$where = "";
		$whereArgs = "";
		$result = array();
		return $result;
	}
	
	public function addLocation(Location $location){
		$table = LocationsContract::LOCATIONS_TABLE_NAME;
		$values = array();
		return $this->dataStorage->insert($table, $values);
	}
	
	public function updateLocation(Location $location){
		$table = LocationsContract::LOCATIONS_TABLE_NAME;
		$values = array();
		$where = "";
		$whereArgs = array();
		return $this->dataStorage->update($table, $values, $where, $whereArgs);
	}
	
	public function deleteLocation(Location $location){
		$table = LocationsContract::LOCATIONS_TABLE_NAME;
		$where = "";
		$whereArgs = array();
		return $this->dataStorage->delete($table, $where, $whereArgs);
	}
}
