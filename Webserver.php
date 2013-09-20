<?php
/**
 * Main file with the processes that the server does.
 *
 * @package Webserver
 */
class Webserver {
	const ERROR_NO_REQUEST = 1;
	const ERROR_WRONG_REQUEST = 2;
	/**
	 * This method must return a string containing the response to the original request.
	 *
	 * An error response should be returned when no matching request is done.
	 *
	 * @return string
	 */
	public function parseRequest() {
		if (isset ( $_GET [self::QUERY_REQUEST] )) {
			switch ($_GET [self::QUERY_REQUEST]) {
				case self::QUERY_REQUEST_LOCATIONS :
					return $this->handleLocationsRequest ();
				default :
				// return $this->getErrorResponse ( self::ERROR_WRONG_REQUEST );
			}
		} else {
			// return $this->getErrorResponse ( self::ERROR_NO_REQUEST );
		}
		return $this->handleLocationsRequest ();
	}
	function getErrorResponse($errorType) {
		switch ($errorType) {
			case ERROR_NO_REQUEST :
				return "";
			case ERROR_WRONG_REQUEST :
				return "";
			default :
				return "QUIETA PUTA! QUE TE HE VISTO!";
		}
	}
	function handleLocationsRequest() {
		include_once ('LocationsService.php');
		$locationsService = new LocationsService ();
	}
}
?>
