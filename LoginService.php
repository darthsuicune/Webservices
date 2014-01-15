<?php
include_once('User.php');
include_once('DbLayer.php');
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
        $projection = array(
        UsersContract::USERS_COLUMN_USERNAME,
        UsersContract::USERS_COLUMN_E_MAIL,
        UsersContract::USERS_COLUMN_ROLE
        );
        $tables = array(UsersContract::USERS_TABLE_NAME);
        $where = UsersContract::USERS_COLUMN_USERNAME . "=% AND " . 
            UsersContract::USERS_COLUMN_PASSWORD . "=%";
        $whereargs = array($username,$password);
        $row = self::getUserData($projection, $tables, $where, $whereargs);
        if($row != null){
            return self::createUser($row[UsersContract::USERS_COLUMN_USERNAME],
            $row[UsersContract::USERS_COLUMN_ROLE],
            $row[UsersContract::USERS_COLUMN_E_MAIL]);
        } else {
            return null;
        }
    }
    /**
     *
     * @return User $user
     */
    public function validateAccessToken($tokenString) {
        if($tokenString == null || $tokenString == "") {
            return null;
        }
        $projection = array(
        UsersContract::USERS_TABLE_NAME . "." . UsersContract::USERS_COLUMN_USERNAME,
        UsersContract::USERS_COLUMN_E_MAIL,
        UsersContract::USERS_COLUMN_ROLE,
        UsersContract::ACCESS_TOKEN_TABLE_NAME . "." . UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN
        );
        $tables = array(UsersContract::USERS_TABLE_NAME, UsersContract::ACCESS_TOKEN_TABLE_NAME);
        $where = UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN . "=%";
        $whereargs = array(
        $tokenString
        );
        $row = self::getUserData($projection, $tables, $where, $whereargs);
        if($row != null){
            return new User(
            $row[UsersContract::USERS_COLUMN_USERNAME],
            $row[UsersContract::USERS_COLUMN_ROLE],
            $row[UsersContract::USERS_COLUMN_E_MAIL],
            new AccessToken($row[UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN])
            );
        } else {
            return null;
        }
    }

    static function getUserData($projection, $tables, $where, $whereargs){
        $dbLayer = new DbLayer();
        if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_SUCCESFUL){
            $data = $dbLayer->query($projection, $tables, $where, $whereargs);
            $row;
            if($data == null){
                $row = null;
            } else {
                $row = $data->fetch_assoc();
            }
            $dbLayer->close();
            return $row;
        } else {
            return null;
        }
    }

    const DB_INSERT_USER = "testinsert";
    const DB_INSERT_PASS = "testpassword";
    static function createUser($username, $role, $email){
        $accessToken = AccessToken::createAccessToken();
        $dbLayer = new DbLayer(DbLayer::DB_ADDRESS, self::DB_INSERT_USER, self::DB_INSERT_PASS, DbLayer::DB_DATABASE);
        if($dbLayer->connect() == DbLayer::RESULT_DB_CONNECTION_SUCCESFUL){
             $result = $dbLayer->insert(UsersContract::ACCESS_TOKEN_TABLE_NAME,
             array(
             UsersContract::ACCESS_TOKEN_USERNAME=>$username,
             UsersContract::ACCESS_TOKEN_COLUMN_LOGIN_TOKEN=>$accessToken->accessTokenString
             ));
            $dbLayer->close();
            return new User($username, $role, $email, $accessToken);
        } else {
            return null;
        }

    }
}