<?php
function testLocationsController(){
	$provider = new MockLocationProvider();
	$controller = new LocationsControllerImpl($provider);
	echo "<td> LocationController tests";
	echo "<td>testGetLocationList<br>\n";
	echo testGetLocations($controller);
	echo "<td>testAddLocation<br>\n";
	echo testAddNewLocation($controller);
	echo "<td>testUpdateLocation<br>\n";
	echo testControllerUpdateLocation($controller);
	echo "<td>testDeleteLocation<br>\n";
	echo testControllerDeleteLocation($controller);
	echo "</td><br>\n";
}

function testGetLocations(LocationsController $controller) {
	$location1 = new Location("12.2", "2.2", "Sitio 1", "asamblea", "Direccion 1", "Tfno 1", 1, 0, 0);
	$location2 = new Location("12.22", "2.22", "Place 2", "bravo", "Address 2", "Phone 2", 3, 0, 1);
}

function testAddNewLocation(LocationsController $controller){
	assertIsTrue("DeleteLocation", $result);
}

function testControllerUpdateLocation(LocationsController $controller){
	assertIsTrue("DeleteLocation", $result);
}

function testControllerDeleteLocation(LocationsController $controller){
	assertIsTrue("DeleteLocation", $result);
}

class MockLocationProvider implements LocationsProvider {
	public function getLocationList(User $user, $lastUpdateTime = 0){
		$location1 = new Location("12.2", "2.2", "Sitio 1", "asamblea", "Direccion 1", "Tfno 1", 1, 0, 0);
		$location2 = new Location("12.22", "2.22", "Place 2", "bravo", "Address 2", "Phone 2", 3, 0, 1);
	}
	
	public function getLocation($id){
		$location4 = new Location("12.2222", "2.2222", "Lage 4", "maritimo", "Addresse 4", "Telefon 4", 5, 1, 3);
		if($id === 3){
			return $location4;
		}
	}

	public function addLocation(Location $location){
		
	}
	public function deleteLocation(Location $location){
		
	}
	public function updateLocation(Location $location){
		
	}
}