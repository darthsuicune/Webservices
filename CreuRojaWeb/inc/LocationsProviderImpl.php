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
		$tables = array(LocationsContract::TABLE_NAME);
		$where = "";
		$whereArgs = array();

		/*The presence of a last update time indicates that the petition
		 * came from a phone that already stores information, so only updated
		 * places should be sent, even if they are expired.
		 * If it's not there, it means that this is a web request or new phone
		 * request, and expired locations should be ignored.
		*/
			
		if($lastUpdateTime == 0){
			$where = "";
			$whereArgs = array();
		} else {
			$where = "";
			$whereArgs = array(LocationsContract::COLUMN_LAST_UPDATED=>$lastUpdateTime);
		}
		$result = $this->dataStorage->query($columns, $tables, $where, $whereArgs);
		return $result;
	}

	public function addLocation(Location $location){
		$table = LocationsContract::TABLE_NAME;
		$values = $location->to_array();
		return $this->dataStorage->insert($table, $values);
	}

	public function updateLocation(Location $location){
		$table = LocationsContract::TABLE_NAME;
		$values = $location->to_array();
		$where = LocationsContract::COLUMN_ID . "=?";
		$whereArgs = array(LocationsContract::COLUMN_ID=>$location->id);
		return $this->dataStorage->update($table, $values, $where, $whereArgs);
	}

	public function deleteLocation(Location $location){
		$table = LocationsContract::TABLE_NAME;
		$where = LocationsContract::COLUMN_ID . "=?";
		$whereArgs = array(LocationsContract::COLUMN_ID=>$location->id);

		return $this->dataStorage->delete($table, $where, $whereArgs);
	}
}
