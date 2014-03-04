<?php
class LocationsProviderImpl implements LocationsProvider {
	var	$dataStorage;
	public function __construct(DataStorage $dataStorage){
		$this->dataStorage = $dataStorage;
	}

	public function getLocationList(User $user, $lastUpdateTime = 0){

	}
	
	public function addLocation(Location $location){
		
	}
	
	public function updateLocation(Location $location){
		
	}
	
	public function deleteLocation(Location $location){
		
	}
}
