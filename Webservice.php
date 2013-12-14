<?php
/**
 * Main file with the processes that the server does.
 *
 * @package Webserver
 */
include_once ('Response.php');
include_once ('LocationsService.php');
include_once ('AccessTokenProvider.php');
class Webservice {
    const QUERY_REQUEST = 'q';
    const QUERY_REQUEST_LOCATIONS = 'get_locations';
    const QUERY_REQUEST_ACCESS_TOKEN = 'request_access';

    /**
     * This method must return a string containing the response to the original request.
     *
     * An error response should be returned when no matching request is done.
     *
     * @return string with the response or fail screen
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
            //Show error message, prepare a response or whatever
            $response = new ErrorResponse(ErrorResponse::ERROR_NO_REQUEST);
        }

        return json_encode($response);
    }
    /**
     * Handles a locations request.
     * In case it is a new user, it should request access first.
     * In case its token was invalidated, an error is returned.
     */
    function handleLocationsRequest() {
        $response;
        if (! isset ( $_POST [AccessTokenProvider::PARAMETER_ACCESS_TOKEN] )) {
            $response = new ErrorResponse ( Response::ERROR_NO_ACCESS_TOKEN );
        }
        $user = AccessTokenProvider::validateAccessToken ();

        if ($user == null) {
            $response = new ErrorResponse ( Response::ERROR_WRONG_ACCESS_TOKEN );
        } else {
            $locationsService = new LocationsService ();
            $locations = $locationsService->getLocations ( $user );
            header("Content-Type: application/json");
            $response =  new LocationsResponse ( $locations );
        }
        return $response;
    }
    /**
     * Handles a request for access.
     * Validates user and password and returns the corresponding token/error message.
     */
    function handleAccessRequest() {
        $response;
        // If an access token is already provided, this should return an error
        if (isset ( $_POST [AccessTokenProvider::PARAMETER_ACCESS_TOKEN] )) {
            $response = new ErrorResponse ( Response::ERROR_ALREADY_HAS_ACCESS_TOKEN );
        }
        // TODO: replace with a way to get the user from the provided login information.
        if (! isset ( $_POST [AccessTokenProvider::PARAMETER_USERNAME] ) ||
        ! isset ( $_POST [AccessTokenProvider::PARAMETER_PASSWORD] )) {
            $response = new ErrorResponse ( Response::ERROR_NO_LOGIN_INFORMATION );
        }

        $user = $_POST [AccessTokenProvider::PARAMETER_USERNAME];
        $pass = $_POST [AccessTokenProvider::PARAMETER_PASSWORD];
        if ($user == "" || $pass == "") {
            $response = new ErrorResponse ( Response::ERROR_WRONG_LOGIN_INFORMATION );
        } else {

            $accessTokenProvider = new AccessTokenProvider ();
            $accessToken = $accessTokenProvider->getAccessToken ($user, $pass);

            if($accessToken->isValid()){
                $locationsService = new LocationsService ();
                $locations = $locationsService->getLocations ( $user, 0 );
                header("Content-Type: application/json");
                $response = new AccessTokenResponse ( $accessToken, $locations );
            } else {
                $response = new ErrorResponse ( Response::ERROR_WRONG_LOGIN_INFORMATION );
            }
        }
        return $response;
    }
}
