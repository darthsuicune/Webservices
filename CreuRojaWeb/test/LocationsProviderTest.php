<?php

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
	$lastUpdateTime = 1;
	$provider->getLocationList($user, $lastUpdateTime);
}

function testAddLocation(LocationsProvider $provider){
	$location = new Location();
	$provider->addLocation($location);
}

function testUpdateLocation(LocationsProvider $provider){
	$location = new Location();
	$provider->updateLocation($location);
}

function testDeleteLocation(LocationsProvider $provider){
	$location = new Location();
	$provider->deleteLocation($location);
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