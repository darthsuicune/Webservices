<?php
    /**
     * Documentation, License etc.
     *
     * @package Webserver
     */
//     include_once('Webserver.php');
//     class DbLayer { 
//         $dbAddress;
//         $dbUsername;
//         $dbPassword;
//         
//         public const DB_ADDRESS = 'localhost'; //TODO: Set values
//         public const DB_USERNAME = 'username'; //TODO: Set values
//         public const DB_PASSWORD = 'password'; //TODO: Set values
//         
//         public function __construct($address, $username, $password) {
//             $this->dbAddress = ($address == '') ? DB_ADDRESS : $address;
//             $this->dbUsername = ($username == '') ? DB_USERNAME: $username;
//             $this->dbPassword = ($password == '') ? DB_PASSWORD : $password;
//         }
//         
//         public function connect() {
//             mysql_connect($this->dbAddress, $this->dbUsername, $this->dbPassword, true, 0);
//         }
//         
//         /**
//         * Methods for user validation
//         */
//         public const DB_FIELD_USERNAME = 'username';
//         public const DB_FIELD_PASSWORD = 'password';
//         
//         public function isValidUser($username, $password) {
//             if(false){
//                 return true;
//             } else {
//                 return false;
//             }
//         }
//         
//         /**
//         * Methods for checking user values
//         */    
//         public function getUserRoles($username) {
//             return array('Maritimo', 'Terrestre', 'Admin');
//         }
//         
//         /**
//         * Methods for retrieving the locations from the DB
//         */
//         
//         /**
//         * @return array with the locations.
//         */
//         const query = "SELECT * FROM puntos WHERE ";
//         
//         public function retrieveFromDb($userDetails) {
//             if($userDetails[Webserver::LAST_UPDATE_TIME_PARAM] == 0){
//                 return array("This", "is", "a", "new", "petition");
//             } else {
//                 return array("But", "this", "is", "old");
//             }
//         }
//     }
?>