<?php
/**
 * Main file with the processes that the server does.
 *
 * @package Webserver
 */
//     include_once 'dblayer.php';
    class Webserver {
        $dbLayer;
//         public const USER_ROLES_PARAM = 'userroles';
//         public const LAST_UPDATE_TIME_PARAM = 'lastupdate';
        
        public function __construct() {
//             $this->dbLayer = new DbLayer('', '', '');
        }
        
        public function parseRequest() {
            echo "TEST";
//             if($dbLayer->isValidUser($_POST[DbLayer::DB_FIELD_USERNAME], $_POST[DbLayer::DB_FIELD_USERNAME])) {
//                 $userDetails = $dbLayer->getUserParameters($_POST[DbLayer::DB_FIELD_USERNAME]);
//                 return createJsonAnswer($userDetails);
//             } else {
//                 return "INVALID CREDENTIALS, MOTHERFUCKER!";
//             }
        }
    
        function getUserParameters($username) {
//             return array(LAST_UPDATE_TIME_PARAM => (isset($_GET[LAST_UPDATE_TIME_PARAM]) 
//                     ? $_GET[LAST_UPDATE_TIME_PARAM] : 0), 
//                     USER_ROLES_PARAM => getUserRoles($username));
        }
    
        function createJsonAnswer($userDetails) {
//             return '[{'.join("},{", $dbLayer->retrieveFromDb($userDetails[USER_ROLES_PARAM])).'}]';
        }
    }
?>
