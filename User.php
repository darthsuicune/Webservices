<?php
include_once('LoginService.php');
class User {
    var $username;
    var $accessToken;
    
    public static function getUserFromLogin($username, $password) {
        //TODO Get details from DB. What follows is temporary data.
        // 1- Check user existance in DB
        // If not exists, return null
        // 2- 
        $user = new User();
        $user->username = $username;
        if($this->accessToken == null){
            $user->accessToken = AccessToken::createAccessToken();
        }
        return $user;
    }
    
    public static function getUserFromToken($accessToken){
        //TODO: Get details from DB
        $user = new User();
        if($user != null){
            $user->username = "testuser";
            $user->accessToken = $accessToken;
        }
    }
    
}