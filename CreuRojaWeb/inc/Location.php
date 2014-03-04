<?php
class Location{
	var $latitude;
	var $longitude;
	var $name;
	var $type;
	var $address;
	var $other;
	var $lastUpdateTime;
	var $expireDate;
	/**
	 * Public constructor
	 */
	public function __construct ( $latitude, $longitude, $name, $type, $address,
			$other, $lastUpdateTime, $expireDate ) {
		$this->latitude = $latitude;
		$this->longitude = $longitude;
		$this->name = $name;
		$this->type = $type;
		$this->address = $address;
		$this->other = $other;
		$this->lastUpdateTime = $lastUpdateTime;
		$this->expireDate = $expireDate;
	}
}