<?php
include_once('User.php');
class LoginService {
	const TOKEN_REQUEST = 1;
	const TOKEN_VALIDATION = 2;
	const TOKEN_ERROR_INVALID_USER_CREDENTIALS = 0;
	/**
	 * 
	 */
	public function getUser($username, $password) {
	    if($username == null || $username == "" || $password == null || $password == ""){
	        return null;
	    }
	    return User::getUserFromLogin($username, $password);
	}
	/**
	 * 
	 * @return User $user
	 */
	public function validateAccessToken($tokenString) {
	    
	}
	/**
	 * 
	 */
	private function createAccessToken($user) {
		//1-Create random crap
		//2-Store random crap in DB related to the user
		//3-Return random crap to user as Access Token
	}
	private function hasValidCredentials($user,$pass) {
		//1-Validate user and password against DB
		return true;
	}
	private function invalidUserCredentials($action) {
		switch ($action) {
			case self::TOKEN_REQUEST :
				return "";
			case self::TOKEN_VALIDATION :
				return "";
			default :
				return "";
		}
	}
}

class AccessToken {
    var $accessTokenString;

    public function __construct($accessToken){
        $this->accessTokenString = $accessToken;
    }

    public function isValid() {
        return ($this->accessTokenString != null && $this->accessTokenString != "");
    }

    public static function isValidToken($accessToken){
        return ($accessToken->accessTokenString != null && $accessToken->accessTokenString != "");
        //1-Check if the token is still in the DB
    }

    public static function createAccessToken(){
        $token = new AccessToken("ACCESS TOKEN");
        return $token;
        //TODO do something useful.
        //         $accessToken = new AccessToken();
        //         $length = random(); // Random number between 15 and 25
        //         $this->accessToken.setAccessToken(self::createRandomString($length));
    }
}