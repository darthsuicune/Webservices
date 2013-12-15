<?php
include_once ('DbLayer.php');
include_once ('Location.php');
class LocationsService {	
	public function getLocations($user, $lastUpdateTime) {
// 		$dbLayer = new DbLayer();
// 		$dbLayer->connect();
// 		TODO: replace with actual DB search
		$result = "";
		if ($lastUpdateTime == 0) {
		    $result = array (
					"This",
					"is",
					"a",
					"new",
					"petition" 
		    );
		} else {
		    $result = array (
					"But",
					"this",
					"is",
					"old" 
		    );
		}
// 		$dbLayer->close();
		return $result;
	}
}