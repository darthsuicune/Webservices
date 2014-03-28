<?php
function testLocationsController(){
	$provider = new MockLocationProvider();
	$controller = new LocationsControllerImpl($provider);
	echo "<td> LocationController tests";
	echo "<td>testGetLocationList<br>\n";
	echo testGetLocationList($controller);
	echo "<td>testAddLocation<br>\n";
	echo testAddLocation($controller);
	echo "<td>testUpdateLocation<br>\n";
	echo testUpdateLocation($controller);
	echo "<td>testDeleteLocation<br>\n";
	echo testDeleteLocation($controller);
	echo "</td><br>\n";
}

class MockLocationProvider implements LocationsProvider {
	public function getLocationList(User $user, $lastUpdateTime = 0){
		
	}

	public function addLocation(Location $location){
		
	}
	public function deleteLocation(Location $location){
		
	}
	public function updateLocation(Location $location){
		
	}
}