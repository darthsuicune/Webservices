<?php
/**
 * Documentation, License etc.
 *
 * @package Webserver
 */
include_once('Webservice.php');
$server = new Webservice();
printf($server->parseRequest());
