<?php

$location1 = new Location("12.2", "2.2", "Sitio 1", "asamblea", "Direccion 1", "Tfno 1", 0, 0);
$location2 = new Location("12.22", "2.22", "Place 2", "maritimo", "Address 2", "Phone 2", 2, 0);
$location3 = new Location("12.222", "2.222", "Lage 3", "bravo", "Addresse 3", "Telefon 3", 4, 0);

function testLocationsProviderImpl(){
	$storage = new MockStorage();
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

	$user = new User();
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;LastUpdateTime 0: ";
	$result = $provider->getLocationList($user, 0);
	assertEquals($result, "{}");

	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;LastUpdateTime 2: ";
	$result = $provider->getLocationList($user, 2);
	assertEquals($result, "{}");

	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;LastUpdateTime 4: ";
	$result = $provider->getLocationList($user, 4);
	assertEquals($result, "{}");
}

function testAddLocation(LocationsProvider $provider){
	$location1 = new Location("12.2", "2.2", "Sitio 1", "asamblea", "Direccion 1", "Tfno 1", 0, 0);
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;AddLocation: ";
	$result = $provider->addLocation($location1);
	assertIsTrue($result);
}

function testUpdateLocation(LocationsProvider $provider){
	$location2 = new Location("12.22", "2.22", "Place 2", "maritimo", "Address 2", "Phone 2", 2, 0);
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;UpdateLocation: ";
	$result = $provider->updateLocation($location2);
	assertIsTrue($result);
}

function testDeleteLocation(LocationsProvider $provider){
	$location3 = new Location("12.222", "2.222", "Lage 3", "bravo", "Addresse 3", "Telefon 3", 4, 0);
	echo "\t&nbsp;&nbsp;&nbsp;&nbsp;DeleteLocation: ";
	$result = $provider->deleteLocation($location3);
	assertIsTrue($result);
}

class MockStorage implements DataStorage {

	public function query(array $columns, array $tables, $where, array $whereArgs) {

	}
	public function insert($table, array $values) {

	}
	public function bulkInsert($table, array $values) {

	}
	public function update($table, array $values, $where, array $whereArgs) {

	}
	public function delete($table, $where, array $whereArgs) {

	}
}