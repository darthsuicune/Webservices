<?php

function testLocationsProviderImpl(){
	$storage = new MockLocationStorage();
	$provider = new LocationsProviderImpl($storage);
	echo "<td> LocationProvider tests";
	echo "<td>testGetLocationList<br>\n";
	echo testGetLocationList($provider);
	echo "<td>testGetLocation<br>\n";
	echo testGetLocation($provider);
	echo "<td>testAddLocation<br>\n";
	echo testAddLocation($provider);
	echo "<td>testUpdateLocation<br>\n";
	echo testUpdateLocation($provider);
	echo "<td>testDeleteLocation<br>\n";
	echo testDeleteLocation($provider);
	echo "</td><br>\n";
}

function testGetLocationList(LocationsProvider $provider) {
	$location1 = new Location("12.2", "2.2", "Sitio 1", "asamblea", "Direccion 1", "Tfno 1", 1, 0, 0);
	$location2 = new Location("12.22", "2.22", "Place 2", "bravo", "Address 2", "Phone 2", 3, 0, 1);
	$location3 = new Location("12.222", "2.222", "Lage 3", "maritimo", "Addresse 3", "Telefon 3", 5, 0, 2);
	$location4 = new Location("12.2222", "2.2222", "Lage 4", "maritimo", "Addresse 4", "Telefon 4", 5, 1, 3);

	$email = "a";
	$role = UsersContract::ROLE_ADMIN;
	$user = new User("a", "a", $email, $role);
	$result = $provider->getLocationList($user, 0);
	assertEquals("LastUpdateTime 0, admin", $result, array($location1, $location2, $location3));

	$role = UsersContract::ROLE_SOCORROS;
	$user = new User("a", "a", $email, $role);
	$result = $provider->getLocationList($user, 2);
	assertEquals("LastUpdateTime 2, socorro", $result, array($location2));

	$role = UsersContract::ROLE_MARITIMOS;
	$user = new User("a", "a", $email, $role);
	$result = $provider->getLocationList($user, 4);
	assertEquals("LastUpdateTime 4, maritimo", $result, array($location3, $location4));

	$role = UsersContract::ROLE_SOCORROS;
	$user = new User("a", "a", $email, $role);
	$result = $provider->getLocationList($user, 6);
	assertEquals("LastUpdateTime 6, socorro", $result, array());
}

function testGetLocation(LocationsProvider $provider){
	$location1 = new Location("12.2", "2.2", "Sitio 1", "asamblea", "Direccion 1", "Tfno 1", 1, 0, 0);
	$id = 0;
	$result = $provider->getLocation($id);
	assertEquals("Id 0", array_values($result->to_array()), array_values($location1->to_array()));
}

function testAddLocation(LocationsProvider $provider){
	$location1 = new Location("12.2", "2.2", "Sitio 1", "asamblea", "Direccion 1", "Tfno 1", 1, 0, 0);
	$result = $provider->addLocation($location1);
	assertIsTrue("AddLocation", $result);
}

function testUpdateLocation(LocationsProvider $provider){
	$location2 = new Location("12.22", "2.22", "Place 2", "bravo", "Address 2", "Phone 2", 3, 0, 1);
	$result = $provider->updateLocation($location2);
	assertIsTrue("UpdateLocation", $result);
}

function testDeleteLocation(LocationsProvider $provider){
	$location3 = new Location("12.222", "2.222", "Lage 3", "maritimo", "Addresse 3", "Telefon 3", 5, 0, 2);
	$result = $provider->deleteLocation($location3);
	assertIsTrue("DeleteLocation", $result);
}

class MockLocationStorage implements DataStorage {
	var $location1;
	var $location2;
	var $location3;
	var $location4;

	public function __construct(){
		$this->location1 = new Location("12.2", "2.2", "Sitio 1", "asamblea", "Direccion 1", "Tfno 1", 1, 0, 0);
		$this->location2 = new Location("12.22", "2.22", "Place 2", "bravo", "Address 2", "Phone 2", 3, 0, 1);
		$this->location3 = new Location("12.222", "2.222", "Lage 3", "maritimo", "Addresse 3", "Telefon 3", 5, 0, 2);
		$this->location4 = new Location("12.2222", "2.2222", "Lage 4", "maritimo", "Addresse 4", "Telefon 4", 5, 1, 3);
	}

	public function query(array $columns, array $tables, $where, array $whereArgs) {
		if(($where == "") || (substr_count($where, "?") != count($whereArgs))){
			return false;
		}

		if(isset($whereArgs[LocationsContract::COLUMN_LAST_UPDATED])){
			switch($whereArgs[LocationsContract::COLUMN_LAST_UPDATED]){
				case 2:
					return array(
					$this->location2->to_array());
				case 4:
					return array($this->location3->to_array(),
					$this->location4->to_array());
				case 6:
					return array();
			}
		} else {
			return array($this->location1->to_array(),
					$this->location2->to_array(),
					$this->location3->to_array());
		}
		return false;
	}

	public function insert($table, array $values) {
		if($table == LocationsContract::TABLE_NAME){
			return ($values[LocationsContract::COLUMN_LATITUDE] == $this->location1->latitude
					&& $values[LocationsContract::COLUMN_LONGITUDE] == $this->location1->longitude
					&& $values[LocationsContract::COLUMN_NAME] == $this->location1->name
					&& $values[LocationsContract::COLUMN_TYPE] == $this->location1->type
					&& $values[LocationsContract::COLUMN_ADDRESS] == $this->location1->address
					&& $values[LocationsContract::COLUMN_OTHER] == $this->location1->other
					&& $values[LocationsContract::COLUMN_LAST_UPDATED] == $this->location1->lastUpdateTime
					&& $values[LocationsContract::COLUMN_EXPIRE_DATE] == $this->location1->expireDate);
		}
		return false;
	}

	public function bulkInsert($table, array $values) {

	}

	public function update($table, array $values, $where, array $whereArgs) {
		if($table == LocationsContract::TABLE_NAME){
			return ($values[LocationsContract::COLUMN_LATITUDE] == $this->location2->latitude
					&& $values[LocationsContract::COLUMN_LONGITUDE] == $this->location2->longitude
					&& $values[LocationsContract::COLUMN_NAME] == $this->location2->name
					&& $values[LocationsContract::COLUMN_TYPE] == $this->location2->type
					&& $values[LocationsContract::COLUMN_ADDRESS] == $this->location2->address
					&& $values[LocationsContract::COLUMN_OTHER] == $this->location2->other
					&& $values[LocationsContract::COLUMN_LAST_UPDATED] == $this->location2->lastUpdateTime
					&& $values[LocationsContract::COLUMN_EXPIRE_DATE] == $this->location2->expireDate);
		}
		return false;
	}

	public function delete($table, $where, array $whereArgs) {
		if($table == LocationsContract::TABLE_NAME){
			return ($whereArgs[LocationsContract::COLUMN_ID] == $this->location3->id);
		}
		return false;
	}
}