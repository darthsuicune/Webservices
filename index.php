<?php
	/**
     * Documentation, License etc.
     *
     * @package Webserver
     */
    include_once('Webserver.php');
    $server = new Webserver();
    echo json_encode($server->parseRequest());

