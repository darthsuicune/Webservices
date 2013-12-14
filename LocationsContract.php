<?php
class LocationsContract {

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

    /**
     * Locations Table
     */
    const LOCATIONS_TABLE_NAME = "locations";
    const LOCATIONS_COLUMN_ID = "id";
    const LOCATIONS_COLUMN_LATITUTDE = "latitude";
    const LOCATIONS_COLUMN_LONGITUDE = "longitude";
    const LOCATIONS_COLUMN_NAME = "name";
    const LOCATIONS_COLUMN_TYPE = "type";
    const LOCATIONS_COLUMN_ADDRESS = "address";
    const LOCATIONS_COLUMN_OTHER = "other";
    const LOCATIONS_COLUMN_LAST_UPDATED = "lastupdated";
    
    const ROLE_SOCIAL = "social";
    const ROLE_SOCORROS = "socorros";
    const ROLE_SOCIAL_SOCORROS = "socialsocorros";
    const ROLE_MARITIMOS = "maritimos";
    const ROLE_ADMIN = "admin";
    const ROLE_SOCORROS_MARITIMOS = "socorrosmaritimos";
    
    const TYPE_ADAPTADAS = "adaptadas";
    const TYPE_ASAMBLEA = "asamblea";
    const TYPE_BRAVO = "bravo";
    const TYPE_CUAP = "cuap";
    const TYPE_HOSPITAL = "hospital";
    const TYPE_MARITIMO = "maritimo";
    const TYPE_NOSTRUM = "nostrum";
    const TYPE_SOCIAL = "social";
    const TYPE_TERRESTRE = "terrestre";
    
    static function getAvailableTypes($role){
        var $types;
        switch($role){
            case self::ROLE_SOCIAL:
                $types = array(
                self::TYPE_SOCIAL,
                self::TYPE_ASAMBLEA
                );
                break;
            case self::ROLE_SOCORROS:
                break;
            case self::ROLE_MARITIMOS:
                break;
            default:
                $types = array();
                break;
        }
        
        return $types;
    }
}