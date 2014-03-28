<?php

class LocationsControllerImpl{
	var $locationsProvider;
	public function __construct(LocationsProvider $locationsProvider) {
		$this->locationsProvider = $locationsProvider;
	}
}