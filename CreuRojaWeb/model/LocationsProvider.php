<?php

interface LocationsProvider {
	/**
	 * 
	 * @param User $user
	 * @param unknown_type $lastUpdateTime
	 * @return array with an array of locations
	 */
	public function getLocationList(User $user, $lastUpdateTime = 0);
	/**
	 *
	 * @param int id
	 * @return Location if succesful, false if not
	 */
	public function getLocation($id);
	/**
	 *
	 * @param Location $location
	 * @return true if succesful, false if not
	 */
	public function addLocation(Location $location);
	/**
	 *
	 * @param Location $location
	 * @return true if succesful, false if not
	 */
	public function deleteLocation(Location $location);
	/**
	 *
	 * @param Location $location
	 * @return true if succesful, false if not
	 */
	public function updateLocation(Location $location);
	
}