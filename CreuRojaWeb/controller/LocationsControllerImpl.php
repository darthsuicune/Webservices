<?php

class LocationsControllerImpl implements LocationsController {
	var $locationsProvider;
	public function __construct(LocationsProvider $locationsProvider) {
		$this->locationsProvider = $locationsProvider;
	}
	public function getLocations(User $user){
		
	}
	public function addNewLocation(){
		
	}
	public function updateLocation(){
		
	}
	public function deleteLocation($id){
		
	}
}