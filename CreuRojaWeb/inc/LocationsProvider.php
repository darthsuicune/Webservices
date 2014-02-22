<?php

interface LocationsProvider {
	public function getLocationList($user, $lastUpdateTime);
}

class LocationsProviderImpl implements LocationsProvider {
	public function __construct(){
		
	}
}
