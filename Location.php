<?php
class Location {
	var $latitude;
	var $longitude;
	var $name;
	var $address;
	var $description;
	var $type;
	var $lastUpdateTime;
	public function __construct() {
		$this->latitude = rand ( 0, 99 );
		$this->longitude = rand ( 100, 199 );
		$this->name = "Test location" . rand ( 200, 299 );
		$this->lastUpdateTime = time ()*1000;
	}
	public function setParameters($latitude, $longitude, $name, $address, $description, $type, 
			$lastUpdateTime) {
		$this->latitude = $latitude;
		$this->longitude = $longitude;
		$this->name = $name;
		$this->address = $address;
		$this->description = $description;
		$this->type = $type;
		$this->lastUpdateTime = $lastUpdateTime;
	}
}