<?php
include_once('DbLayer.php');
class User {
    var $username;
    var $role;
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

class UsersContract {
    /**
     * Users table
     */
    const USERS_TABLE_NAME = "users";
    const USERS_COLUMN_ID = "ID";
    const USERS_COLUMN_USERNAME = "username";
    const USERS_COLUMN_PASSWORD = "password";
    const USERS_COLUMN_E_MAIL = "email";
    const USERS_COLUMN_LOGIN_TOKEN = "logintoken";
    const USERS_COLUMN_ROLE = "role";

    const ROLE_SOCIAL = "social";
    const ROLE_SOCORROS = "socorros";
    const ROLE_SOCIAL_SOCORROS = "socialsocorros";
    const ROLE_MARITIMOS = "maritimos";
    const ROLE_ADMIN = "admin";
    const ROLE_SOCORROS_MARITIMOS = "socorrosmaritimos";
}