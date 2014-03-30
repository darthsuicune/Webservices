<?php

interface LocationsController {
	/**
	 * 
	 * @param User $user
	 */
	public function getLocations(User $user);
	/**
	 * 
	 * @return true if it was added, false otherwise
	 */
	public function addNewLocation();
	/**
	 *
	 * @return true if it was updated, false otherwise
	 */
	public function updateLocation();
	/**
	 * 
	 * @param int $id ID of the location to remove
	 * @return true if it was deleted, false otherwise
	 */
	public function deleteLocation($id);
}