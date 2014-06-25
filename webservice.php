<?php
/**
 * Main file with the processes that the server does.
 *
 * @package Webserver
 */
include_once ('Response.php');
include_once ('LocationsService.php');
include_once ('LoginService.php');
include_once ('User.php');

$server = new Webservice ();
print ( $server->parseRequest () );

class Webservice {
	const QUERY_REQUEST = 'q';
	const QUERY_REQUEST_LOCATIONS = 'get_locations';
	const QUERY_REQUEST_ACCESS_TOKEN = 'request_access';

	const PARAMETER_EMAIL = "email";
	const PARAMETER_PASSWORD = "password";
	const PARAMETER_ACCESS_TOKEN = "access_token";
	const PARAMETER_LAST_UPDATE_TIME = 'last_update';
	const PARAMETER_VERSION = "version";
	var $version;

	/**
	 * This method must $response = a string containing the response to the original request.
	 *
	 * An error response should be returned when no matching request is done.
	 *
	 * @$response = string with the response or fail screen
	 */
	public function parseRequest() {
		if(isset ($_GET [self::PARAMETER_VERSION])){
			$this->version = $_GET [self::PARAMETER_VERSION];
		} else {
			$this->version = "unreported";
		}
		$response;
		if (isset ( $_GET [self::QUERY_REQUEST] )) {
			switch ($_GET [self::QUERY_REQUEST]) {
				case self::QUERY_REQUEST_LOCATIONS :
					$response = $this->handleLocationsRequest ();
					break;
				case self::QUERY_REQUEST_ACCESS_TOKEN :
					$response = $this->handleAccessRequest ();
					break;
				default :
					$response = new ErrorResponse ( Response::ERROR_WRONG_REQUEST );
					Log::failWrite(null, "webservice " . $response->errorMessage, $this->version);
					break;
			}
		} else {
			$response = new ErrorResponse ( Response::ERROR_NO_REQUEST );
			Log::failWrite(null, "webservice " . $response->errorMessage, $this->version);
		}

		return $response;
	}
	/**
	 * Handles a locations request.
	 * In case it is a new user, it should request access first.
	 * In case its token was invalidated, an error is returned.
	 */
	function handleLocationsRequest() {
		$response;
		if (! isset ( $_POST [self::PARAMETER_ACCESS_TOKEN] )) {
			$response = new ErrorResponse ( Response::ERROR_NO_ACCESS_TOKEN );
			Log::failWrite(null, "webservice " . $response->errorMessage, $this->version);
		} else {
			$loginService = new LoginService ();
			$user = $loginService->validateAccessToken ($_POST [self::PARAMETER_ACCESS_TOKEN]);

			if ($user == null || (!$user->accessToken->isValid())) {
				$response = new ErrorResponse ( Response::ERROR_WRONG_ACCESS_TOKEN );
				Log::failWrite(null, "webservice " . $response->errorMessage, $this->version);
			} else {
				$lastUpdateTime = 0;
				if (isset ($_POST [self::PARAMETER_LAST_UPDATE_TIME])){
					$lastUpdateTime = $_POST [self::PARAMETER_LAST_UPDATE_TIME];
				}
				$locationsService = new LocationsService ();
				$locations = $locationsService->getLocations ( $user, $lastUpdateTime );

				$response = new LocationsResponse ( $locations );

				Log::write($user, self::QUERY_REQUEST_LOCATIONS, $this->version);
			}
		}
		header("Content-Type: application/json");
		return json_encode($response);
	}
	/**
	 * Handles a request for access.
	 * Validates user and password and returns the corresponding response/error message.
	 */
	function handleAccessRequest() {
		$response;
		// If an access token is already provided, this should $response = an error
		if (isset ( $_POST [self::PARAMETER_ACCESS_TOKEN] )) {
			$response = new ErrorResponse ( Response::ERROR_ALREADY_HAS_ACCESS_TOKEN );
			Log::failWrite(null, "webservice " . $response->errorMessage, $this->version);
		} else if (! isset ( $_POST [self::PARAMETER_EMAIL] ) ||
				! isset ( $_POST [self::PARAMETER_PASSWORD] )) {
			$response = new ErrorResponse ( Response::ERROR_NO_LOGIN_INFORMATION );
			Log::failWrite(null, "webservice " . $response->errorMessage, $this->version);
		} else {

			$email = $_POST [self::PARAMETER_EMAIL];
			$password = $_POST [self::PARAMETER_PASSWORD];
			if ($email == "" || $password == "") {
				$response = new ErrorResponse ( Response::ERROR_WRONG_LOGIN_INFORMATION );
				Log::failWrite(null, "webservice " . $response->errorMessage, $this->version);
			} else {
				$loginService = new LoginService ();
				$user = $loginService->checkUser ($email, $password);
				if($user == null || !($user->accessToken->isValid())){
					$response = new ErrorResponse ( Response::ERROR_WRONG_LOGIN_INFORMATION );
					Log::failWrite(null, "webservice " . $response->errorMessage, $this->version);
				} else {
					$locationsService = new LocationsService ();
					$locations = $locationsService->getLocations ( $user, 0 );
					$response = new LoginResponse ( $user->accessToken, $locations );
					Log::write($user, self::QUERY_REQUEST_ACCESS_TOKEN, $this->version);
				}
			}
		}
		header("Content-Type: application/json");
		return json_encode($response);
	}
}
