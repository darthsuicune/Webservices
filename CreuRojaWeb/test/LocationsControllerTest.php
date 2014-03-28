<?php
function testLocationsController(){
	$provider = new MockLocationProvider();
	$controller = new LocationsControllerImpl($provider);
	echo "<td> LocationController tests";
	echo "<td>testGetLocationList<br>\n";
	echo testGetLocationList1($controller);
	echo "<td>testAddLocation<br>\n";
	echo testAddLocation1($controller);
	echo "<td>testUpdateLocation<br>\n";
	echo testUpdateLocation1($controller);
	echo "<td>testDeleteLocation<br>\n";
	echo testDeleteLocation1($controller);
	echo "</td><br>\n";
}

function testGetLocationList1(LocationsController $controller) {
	
}

function testAddLocation1(LocationsController $controller){
	
}

function testUpdateLocation1(LocationsController $controller){
	
}

function testDeleteLocation1(LocationsController $controller){
	
}

class MockLocationProvider implements LocationsProvider {
	public function getLocationList(User $user, $lastUpdateTime = 0){
		
	}
	
	public function getLocation($id){
		
	}

	public function addLocation(Location $location){
		
	}
	public function deleteLocation(Location $location){
		
	}
	public function updateLocation(Location $location){
		
	}
}