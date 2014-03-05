<?php

function testLocationsProviderImpl(){
	$storage = new MockLocationStorage();
	$provider = new LocationsProviderImpl($storage);
	echo "<td> LocationProvider tests";
	echo "<td>testGetLocationList<br>\n";
	echo testGetLocationList($provider);
	echo "<td>testAddLocation<br>\n";
	echo testAddLocation($provider);
	echo "<td>testUpdateLocation<br>\n";
	echo testUpdateLocation($provider);
	echo "<td>testDeleteLocation<br>\n";
	echo testDeleteLocation($provider);
	echo "</td><br>\n";
}

function testGetLocationList(LocationsProvider $provider) {
	$location1 = new Location("12.2", "2.2", "Sitio 1", "asamblea", "Direccion 1", "Tfno 1", 1, 0);
	$location2 = new Location("12.22", "2.22", "Place 2", "maritimo", "Address 2", "Phone 2", 3, 0);
	$location3 = new Location("12.222", "2.222", "Lage 3", "bravo", "Addresse 3", "Telefon 3", 5, 0);

	$email = "a";
	$role = "admin";
	$user = new User($email, $role);
	$result = $provider->getLocationList($user, 0);
	assertEquals("LastUpdateTime 0, admin", $result, array($location1, $location2, $location3));

	$role = UsersContract::ROLE_MARITIMOS;
	$user = new User($email, $role);	
	$result = $provider->getLocationList($user, 2);
	assertEquals("LastUpdateTime 2, maritimo", $result, array($location2));

	$role = UsersContract::ROLE_SOCORROS;
	$user = new User($email, $role);	
	$result = $provider->getLocationList($user, 4);
	assertEquals("LastUpdateTime 4, socorro", $result, array($location3));

	$user = new User($email, $role);	
	$result = $provider->getLocationList($user, 6);
	assertEquals("LastUpdateTime 6, wat", $result, array());
}

function testAddLocation(LocationsProvider $provider){
	$location1 = new Location("12.2", "2.2", "Sitio 1", "asamblea", "Direccion 1", "Tfno 1", 0, 0);
	$result = $provider->addLocation($location1);
	assertIsTrue("AddLocation", $result);
}

function testUpdateLocation(LocationsProvider $provider){
	$location2 = new Location("12.22", "2.22", "Place 2", "maritimo", "Address 2", "Phone 2", 2, 0);
	$result = $provider->updateLocation($location2);
	assertIsTrue("UpdateLocation", $result);
}

function testDeleteLocation(LocationsProvider $provider){
	$location3 = new Location("12.222", "2.222", "Lage 3", "bravo", "Addresse 3", "Telefon 3", 4, 0);
	$result = $provider->deleteLocation($location3);
	assertIsTrue("DeleteLocation", $result);
}

class MockLocationStorage implements DataStorage {
	var $location1;
	var $location2;
	var $location3;

	public function __construct(){
		$this->location1 = new Location("12.2", "2.2", "Sitio 1", "asamblea", "Direccion 1", "Tfno 1", 1, 0);
		$this->location2 = new Location("12.22", "2.22", "Place 2", "maritimo", "Address 2", "Phone 2", 3, 0);
		$this->location3 = new Location("12.222", "2.222", "Lage 3", "bravo", "Addresse 3", "Telefon 3", 5, 0);
	}

	public function query(array $columns, array $tables, $where, array $whereArgs) {

	}

	public function insert($table, array $values) {
		if($table == LocationsContract::LOCATIONS_TABLE_NAME){
			return ($values[LocationsContract::LOCATIONS_COLUMN_LATITUDE] == $this->location1->latitude
					&& $values[LocationsContract::LOCATIONS_COLUMN_LONGITUDE] == $this->location1->longitude
					&& $values[LocationsContract::LOCATIONS_COLUMN_NAME] == $this->location1->name
					&& $values[LocationsContract::LOCATIONS_COLUMN_TYPE] == $this->location1->type
					&& $values[LocationsContract::LOCATIONS_COLUMN_ADDRESS] == $this->location1->address
					&& $values[LocationsContract::LOCATIONS_COLUMN_OTHER] == $this->location1->other
					&& $values[LocationsContract::LOCATIONS_COLUMN_LAST_UPDATED] == $this->location1->lastUpdateTime
					&& $values[LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE] == $this->location1->expireDate);
		}
		return false;
	}

	public function bulkInsert($table, array $values) {

	}

	public function update($table, array $values, $where, array $whereArgs) {
		if($table == LocationsContract::LOCATIONS_TABLE_NAME){
			return ($values[LocationsContract::LOCATIONS_COLUMN_LATITUDE] == $this->location2->latitude
					&& $values[LocationsContract::LOCATIONS_COLUMN_LONGITUDE] == $this->location2->longitude
					&& $values[LocationsContract::LOCATIONS_COLUMN_NAME] == $this->location2->name
					&& $values[LocationsContract::LOCATIONS_COLUMN_TYPE] == $this->location2->type
					&& $values[LocationsContract::LOCATIONS_COLUMN_ADDRESS] == $this->location2->address
					&& $values[LocationsContract::LOCATIONS_COLUMN_OTHER] == $this->location2->other
					&& $values[LocationsContract::LOCATIONS_COLUMN_LAST_UPDATED] == $this->location2->lastUpdateTime
					&& $values[LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE] == $this->location2->expireDate);
		}
		return false;
	}

	public function delete($table, $where, array $whereArgs) {
		if($table == LocationsContract::LOCATIONS_TABLE_NAME){
			return ($values[LocationsContract::LOCATIONS_COLUMN_LATITUDE] == $this->location3->latitude
					&& $values[LocationsContract::LOCATIONS_COLUMN_LONGITUDE] == $this->location3->longitude
					&& $values[LocationsContract::LOCATIONS_COLUMN_NAME] == $this->location3->name
					&& $values[LocationsContract::LOCATIONS_COLUMN_TYPE] == $this->location3->type
					&& $values[LocationsContract::LOCATIONS_COLUMN_ADDRESS] == $this->location3->address
					&& $values[LocationsContract::LOCATIONS_COLUMN_OTHER] == $this->location3->other
					&& $values[LocationsContract::LOCATIONS_COLUMN_LAST_UPDATED] == $this->location3->lastUpdateTime
					&& $values[LocationsContract::LOCATIONS_COLUMN_EXPIRE_DATE] == $this->location3->expireDate);
		}
		return false;
	}
}