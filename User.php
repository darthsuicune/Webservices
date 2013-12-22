<?php
include_once('Location.php');
class UsersContract {
    /**
     * Users table
     */
    const USERS_TABLE_NAME = "users";
    const USERS_COLUMN_ID = "ID";
    const USERS_COLUMN_USERNAME = "username";
    const USERS_COLUMN_PASSWORD = "password";
    const USERS_COLUMN_E_MAIL = "email";
    const USERS_COLUMN_ROLE = "role";

    const ACCESS_TOKEN_TABLE_NAME = "accesstoken";
    const ACCESS_TOKEN_USERNAME = "username";
    const ACCESS_TOKEN_COLUMN_LOGIN_TOKEN = "accesstoken";

    const ROLE_SOCIAL = "social";
    const ROLE_SOCORROS = "socorros";
    const ROLE_SOCIAL_SOCORROS = "socialsocorros";
    const ROLE_MARITIMOS = "maritimos";
    const ROLE_ADMIN = "admin";
    const ROLE_SOCORROS_MARITIMOS = "socorrosmaritimos";
}

class User {
    var $username;
    var $role;
    var $email;
    var $accessToken;

    function __construct( $username, $role, $email, $accessToken){
        $this->username = $username;
        $this->role = $role;
        $this->email = $email;
        $this->accessToken = $accessToken;
    }

    public function getAllowedTypes(){
        $types;
        switch($this->role){
            case UsersContract::ROLE_SOCIAL_SOCORROS:
                $types[] = LocationsContract::TYPE_SOCIAL;
            case UsersContract::ROLE_SOCORROS:
                $this->addSocorros($types);
                break;
            case UsersContract::ROLE_SOCORROS_MARITIMOS:
                $this->addSocorros($types);
            case UsersContract::ROLE_MARITIMOS:
                $types[] = LocationsContract::TYPE_MARITIMO;
                break;
            case UsersContract::ROLE_SOCIAL:
                $types[] = LocationsContract::TYPE_SOCIAL;
                $types[] = LocationsContract::TYPE_ASAMBLEA;
                break;
            case UsersContract::ROLE_ADMIN:
                $this->addSocorros($types);
                $types[] = LocationsContract::TYPE_SOCIAL;
                $types[] = LocationsContract::TYPE_MARITIMO;
                break;
        }
        return join("','", $types);
    }

    function addSocorros(&$array){
        $array[] = LocationsContract::TYPE_ADAPTADAS;
        $array[] = LocationsContract::TYPE_ASAMBLEA;
        $array[] = LocationsContract::TYPE_BRAVO;
        $array[] = LocationsContract::TYPE_CUAP;
        $array[] = LocationsContract::TYPE_HOSPITAL;
        $array[] = LocationsContract::TYPE_NOSTRUM;
        $array[] = LocationsContract::TYPE_TERRESTRE;
        return $array;
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

    public static function createAccessToken(){
        //This method generates the sha1 hash of the time with length 30.
        $token = new AccessToken(substr(sha1(microtime()), 0, 30)); 
        return $token;
    }
}

