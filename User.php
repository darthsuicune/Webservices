<?php
class User {
    var $username;
    var $accessToken;
    
    public function __construct($accessToken) {
        $this->accessToken = new AccessToken($accessToken);
    }
    
}
class AccessToken {
    var $accessTokenString;
    
    public function __construct($accessToken){
        $this->accessTokenString = $accessToken;
    }
    
    public function isValid() {
        return ($this->accessTokenString != null);
    }
    
    public function setAccessToken($newAccessToken){
        $this->accessTokenString = $newAccessToken;
    }
    
    public static function isValidToken($accessToken){
        //1-Check if the token is still in the DB
    }
    
    public function createAccessToken(){
        $accessToken = new AccessToken();
        $length = random(); // Random number between 15 and 25
        $this->accessToken.setAccessToken(self::createRandomString($length));
    }
}