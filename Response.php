<?php
abstract class Response{
	const NO_ERROR = 0;
	const ERROR_NO_REQUEST = 1;
	const ERROR_WRONG_REQUEST = 2;
	const ERROR_WRONG_ACCESS_TOKEN = 3;
	const ERROR_NO_ACCESS_TOKEN = 4;
	const ERROR_ALREADY_HAS_ACCESS_TOKEN = 5;
}
class ErrorResponse extends Response {
	var $errorCode;
	var $errorMessage;
	
	public function __construct($errorCode) {
		$this->errorCode = $errorCode;
		switch ($errorCode) {
			case self::ERROR_NO_REQUEST :
				$this->errorMessage = "\"I AM ALIVE!!! (and you're wrong ~~)\"";
			case self::ERROR_WRONG_REQUEST :
				$this->errorMessage = "\"QUIETA PUTA! QUE TE HE VISTO!\"";
			case self::ERROR_WRONG_ACCESS_TOKEN :
				$this->errorMessage = "\"This Access Token is no longer valid.\"";
			case self::ERROR_NO_ACCESS_TOKEN :
				$this->errorMessage = "\"You haven't requested access yet, bitch!\"";
			case self::ERROR_ALREADY_HAS_ACCESS_TOKEN:
				$this->errorMessage = "Wait, wat?";
			default :
				$this->errorMessage = "\"QUIETA PUTA! QUE TE HE VISTO ~~\"";
		}
	}
}
class LocationsResponse extends Response {
	var $locations;
	
	public function __construct($locations) {
		$this->locations = $locations;
	}
}
class AccessTokenResponse extends LocationsResponse {
	var $accessToken;
	public function __construct($accessToken, $locations) {
		$this->accessToken = $accessToken;
		$this->locations = $locations;
	}
}