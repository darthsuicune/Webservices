<?php
/**
 * Main file with the processes that the server does.
 *
 * @package Webserver
 */
class Webserver {
	const ERROR_NO_REQUEST = 1;
	const ERROR_WRONG_REQUEST = 2;
	const ERROR_WRONG_ACCESS_TOKEN = 3;
	const ERROR_NO_ACCESS_TOKEN = 4;
	const QUERY_REQUEST = 'q';
	const QUERY_REQUEST_LOCATIONS = 'get_locations';
	const QUERY_REQUEST_ACCESS_TOKEN = 'request_access';
	
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
				case self::QUERY_REQUEST_ACCESS_TOKEN :
					return $this->handleAccessRequest ();
				default :
					return $this->getErrorResponse ( self::ERROR_WRONG_REQUEST );
			}
		} else {
			return $this->getErrorResponse ( self::ERROR_NO_REQUEST );
		}
	}
	/**
	 * Convenience method for error handling.
	 * Returns an error message in case there was a
	 * wrong request or no request at all (malformed request).
	 *
	 * @param unknown $errorType        	
	 * @return string
	 */
	function getErrorResponse($errorType) {
		switch ($errorType) {
			case self::ERROR_NO_REQUEST :
				return "\"I AM ALIVE!!! (and you're wrong ~~)\"";
			case self::ERROR_WRONG_REQUEST :
				return "\"QUIETA PUTA! QUE TE HE VISTO!\"";
			case self::ERROR_WRONG_ACCESS_TOKEN :
				return "\"This Access Token is no longer valid.\"";
			case self::ERROR_NO_ACCESS_TOKEN :
				return "\"You haven't requested access yet, bitch!\"";
			default :
				return "\"QUIETA PUTA! QUE TE HE VISTO ~~\"";
		}
	}
	/**
	 * Handles a locations request.
	 * In case it is a new user, it should request access first.
	 * In case its token was invalidated, an error is returned.
	 */
	function handleLocationsRequest() {
		include_once ('LocationsService.php');
		include_once ('AccessTokenProvider.php');
		$locationsService = new LocationsService ();
		// TODO: Add ! to isset when testing with actual clients or it won't work ¬¬
		if (isset ( $_POST [AccessTokenProvider::PARAMETER_ACCESS_TOKEN] )) {
			return $this->getErrorResponse ( self::ERROR_NO_ACCESS_TOKEN );
		}
		if (AccessTokenProvider::validateAccessToken ()) {
			return "\'locationList\'=[{".$locationsService->getLocations ()."}]";
		} else {
			return $this->getErrorResponse ( self::ERROR_WRONG_ACCESS_TOKEN );
		}
	}
	/**
	 * Handles a request for access.
	 * Validates user and password and returns the corresponding token/error message.
	 */
	function handleAccessRequest() {
		include_once ('AccessTokenProvider.php');
		$accessToken = new AccessTokenProvider ();
		return $accessToken->getAccessToken ();
	}
}
