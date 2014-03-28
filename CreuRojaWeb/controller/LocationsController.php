<?php

interface LocationsController {
	public function getLocations(User $user);
	public function addNewLocation();
	public function updateLocation();
	public function deleteLocation($id);
}