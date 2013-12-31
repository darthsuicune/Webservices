<?php
/**
 * Documentation, License etc.
 *
 * @package Webserver
 */
include_once ('Webservice.php');
$server = new Webservice ();
print ( $server->parseRequest () );

// echo "\n" . "TEST" . "\n";
// include_once ('DbLayer.php');
// include_once('Location.php');
// $columns = array ();
// $tables = array (LocationsContract::LOCATIONS_TABLE_NAME);
// $where = LocationsContract::LOCATIONS_COLUMN_TYPE . "=%";
// $whereargs = array ('cuap');

// $dbLayer = new DbLayer ();
// $dbLayer->connect ();
// $result = $dbLayer->query ( $columns, $tables, $where, $whereargs );
// if (result != null) {
// 	while ($row = $result->fetch_assoc()) {
// 		echo json_encode(new Location($row)) . "\n";
// 		echo json_last_error() . "\n";
// 	}
// }
// $dbLayer->close ();