<?php
class LocationsContract {
	/**
	 * Locations Table
	 */
	const TABLE_NAME = "locations";
	const COLUMN_ID = "id";
	const COLUMN_LATITUDE = "latitude";
	const COLUMN_LONGITUDE = "longitude";
	const COLUMN_NAME = "name";
	const COLUMN_TYPE = "type";
	const COLUMN_ADDRESS = "address";
	const COLUMN_OTHER = "other";
	const COLUMN_LAST_UPDATED = "lastupdated";
	const COLUMN_EXPIRE_DATE = "expiredate";

	const TYPE_ADAPTADAS = "adaptadas";
	const TYPE_ASAMBLEA = "asamblea";
	const TYPE_BRAVO = "bravo";
	const TYPE_CUAP = "cuap";
	const TYPE_HOSPITAL = "hospital";
	const TYPE_MARITIMO = "maritimo";
	const TYPE_NOSTRUM = "nostrum";
	const TYPE_SOCIAL = "social";
	const TYPE_TERRESTRE = "terrestre";

	public static function getLocationTypes(){
		return array(
				'adaptadas',
				'asamblea',
				'bravo',
				'cuap',
				'hospital',
				'maritimo',
				'nostrum',
				'social',
				'terrestre'
		);
	}
}