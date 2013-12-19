<?php
/**
 * Documentation, License etc.
 *
 * @package Webserver
 */
include_once('Webservice.php');
$server = new Webservice();
echo $server->parseRequest();

include_once('DbLayer.php');
$dblayer = new DbLayer();
echo "\n" . $dblayer->connect();
$projection = array();
$tables = array(locations);
$where = "";
$whereargs = array();
echo $dblayer->query(null, $tables, null, null);
// echo "\n" . $dblayer->query(); 
// echo "\n" . $dblayer->query();
$dblayer->close();