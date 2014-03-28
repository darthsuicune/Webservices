<?php
class LocationsProviderImpl implements LocationsProvider {
	var	$dataStorage;
	public function __construct(DataStorage $dataStorage){
		$this->dataStorage = $dataStorage;
	}

	public function getLocationList(User $user, $lastUpdateTime = 0){
		$columns = array();
		$tables = array(LocationsContract::TABLE_NAME);
		$where = LocationsContract::COLUMN_TYPE . " IN ("
			. implode(',', array_fill(0, count($user->getAllowedTypes()), '?')) . ") AND ";
		$whereArgs = $user->getAllowedTypes();

		/*The presence of a last update time indicates that the petition
		 * came from a phone that already stores information, so only updated
		* places should be sent, even if they are expired.
		* If it's not there, it means that this is a web request or new phone
		* request, and expired locations should be ignored.
		*
		* LastUpdateTime = 0 -> Check expire date
		* LastUpdateTime != 0 -> Don't check expire date
		*/
		if($lastUpdateTime == 0){
			$where .= "(" . LocationsContract::COLUMN_EXPIRE_DATE . "=0 OR "
			. LocationsContract::COLUMN_EXPIRE_DATE . ">?)";
			$whereArgs[LocationsContract::COLUMN_EXPIRE_DATE] = round(microtime(true) * 1000);
		} else {
			$where .= LocationsContract::COLUMN_LAST_UPDATED . ">?";
			$whereArgs[LocationsContract::COLUMN_LAST_UPDATED] = $lastUpdateTime;
		}
		$result = $this->dataStorage->query($columns, $tables, $where, $whereArgs);
		return $this->getLocationListFromCursor($result);
	}
	
	public function getLocation($id){
		if ($id < 0) {
			return false;
		}
		$columns = array();
		$tables = array(LocationsContract::TABLE_NAME);
		$where = LocationsContract::COLUMN_ID . "=?";
		$whereArgs = array($id);
		$result = $this->dataStorage->query($columns, $tables, $where, $whereArgs);
		$location = $this->getLocationListFromCursor($result);
		return $location[0];
	}

	public function addLocation(Location $location){
		$table = LocationsContract::TABLE_NAME;
		$values = $location->to_array(false);
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

	function getLocationListFromCursor(array $cursor){
		$result = array();
		foreach($cursor as $entry){
			$result[] = Location::createFromCursor($entry);
		}
		return $result;
	}
}
