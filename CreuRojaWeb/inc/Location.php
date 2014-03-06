<?php
class Location{
	var $id;
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
			$other, $lastUpdateTime, $expireDate, $id = 0 ) {
		$this->id = $id;
		$this->latitude = $latitude;
		$this->longitude = $longitude;
		$this->name = $name;
		$this->type = $type;
		$this->address = $address;
		$this->other = $other;
		$this->lastUpdateTime = $lastUpdateTime;
		$this->expireDate = $expireDate;
	}

	public function to_array(){
		return array(LocationsContract::COLUMN_LATITUDE=>$this->latitude,
				LocationsContract::COLUMN_LONGITUDE=>$this->longitude,
				LocationsContract::COLUMN_NAME=>$this->name,
				LocationsContract::COLUMN_TYPE=>$this->type,
				LocationsContract::COLUMN_ADDRESS=>$this->address,
				LocationsContract::COLUMN_OTHER=>$this->other,
				LocationsContract::COLUMN_LAST_UPDATED=>$this->lastUpdateTime,
				LocationsContract::COLUMN_EXPIRE_DATE=>$this->expireDate);
	}
}