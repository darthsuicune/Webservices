<?php

interface LocationsProvider {
	/**
	 * 
	 * @param User $user
	 * @param unknown_type $lastUpdateTime
	 */
	public function getLocationList(User $user, $lastUpdateTime = 0);
	/**
	 * 
	 * @param Location $location
	 */
	public function addLocation(Location $location);
	/**
	 * 
	 * @param Location $location
	 */
	public function deleteLocation(Location $location);
	/**
	 * 
	 * @param Location $location
	 */
	public function updateLocation(Location $location);
}