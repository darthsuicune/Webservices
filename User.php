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
    const ROLE_REGISTER = "registrador";
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
        $this->accessToken = new AccessToken($accessToken);
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
        return $types;
    }
    
    public static function generateHash($password){
    	return sha1($password);
    }
    
    public function changePassword($newPassword){
    	
    }
    
    public function createNewPassword(){
    	
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

    const DB_INSERT_USER = "testinsert";
    const DB_INSERT_PASS = "testpassword";
    public static function generateToken($username, $role, $email){
        $accessToken = AccessToken::createAccessToken();
        $dbLayer = new DbLayer(DbLayer::DB_ADDRESS, self::DB_INSERT_USER, self::DB_INSERT_PASS, DbLayer::DB_DATABASE);
        if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_SUCCESFUL){
             $result = $dbLayer->insert(UsersContract::ACCESS_TOKEN_TABLE_NAME,
             array(
             UsersContract::ACCESS_TOKEN_USERNAME=>$username,
             UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN=>$accessToken->accessTokenString
             ));
            $dbLayer->close();
            return new User($username, $role, $email, $accessToken->accessTokenString);
        } else {
            return null;
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

    public static function createAccessToken(){
        //This method generates a random string.
        $token = new AccessToken(substr(sha1(microtime()), 0, 30)); 
        return $token;
    }
}

