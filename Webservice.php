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
class Webservice {
    const QUERY_REQUEST = 'q';
    const QUERY_REQUEST_LOCATIONS = 'get_locations';
    const QUERY_REQUEST_ACCESS_TOKEN = 'request_access';

    const PARAMETER_USERNAME = "username";
    const PARAMETER_PASSWORD = "password";
    const PARAMETER_ACCESS_TOKEN = "access_token";
    const PARAMETER_LAST_UPDATE_TIME = 'last_update';

    /**
     * This method must $response = a string containing the response to the original request.
     *
     * An error response should be returned when no matching request is done.
     *
     * @$response = string with the response or fail screen
     */
    public function parseRequest() {
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
                break;
            }
        } else {
        	//No request means web petition... for now.
        	$response = $this->handleWebRequest();
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
        }
        $user = LoginService::validateAccessToken ($_POST [self::PARAMETER_ACCESS_TOKEN]);

        if ($user == null || (!$user->accessToken->isValid())) {
            $response = new ErrorResponse ( Response::ERROR_WRONG_ACCESS_TOKEN );
        } else {
            $lastUpdateTime = 0;
            if (isset ($_POST [self::PARAMETER_LAST_UPDATE_TIME])){
                $lastUpdateTime = $_POST [self::PARAMETER_LAST_UPDATE_TIME];
            }
            $locationsService = new LocationsService ();
            $locations = $locationsService->getLocations ( $user, $lastUpdateTime );
            
            $response = new LocationsResponse ( $locations );
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
        }
        // TODO: replace with a way to get the user from the provided login information.
        if (! isset ( $_POST [self::PARAMETER_USERNAME] ) ||
        ! isset ( $_POST [self::PARAMETER_PASSWORD] )) {
            $response = new ErrorResponse ( Response::ERROR_NO_LOGIN_INFORMATION );
        }

        $username = $_POST [self::PARAMETER_USERNAME];
        $password = $_POST [self::PARAMETER_PASSWORD];
        if ($username == "" || $password == "") {
            $response = new ErrorResponse ( Response::ERROR_WRONG_LOGIN_INFORMATION );
        } else {
            $LoginService = new LoginService ();
            $user = $LoginService->checkUser ($username, $password);
            if($user == null || !($user->accessToken->isValid())){
                $response = new ErrorResponse ( Response::ERROR_WRONG_LOGIN_INFORMATION );
            } else {
                $locationsService = new LocationsService ();
                $locations = $locationsService->getLocations ( $user, 0 );
                $response = new LoginResponse ( $user->accessToken, $locations );
            }
        }
        header("Content-Type: application/json");
        return json_encode($response);
    }
    
    function handleWebRequest(){
    	include_once('WebRequest.php');
    	$webRequest = new WebRequest();
    	return $webRequest->parseRequest();
    }
}
