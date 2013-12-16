<?php
include_once('User.php');
class LoginService {
    const TOKEN_REQUEST = 1;
    const TOKEN_VALIDATION = 2;
    const TOKEN_ERROR_INVALID_USER_CREDENTIALS = 0;
    /**
     *
     */
    public function checkUser($username, $password) {
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
        if($tokenString == null || $tokenString == "") {
            return null;
        }
        return User::getUserFromToken($tokenString);
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
        $token = new AccessToken(substr(sha1(time()), 0, 30)); //This method generates the sha1 hash of the time with length 30.
        return $token;
    }
}