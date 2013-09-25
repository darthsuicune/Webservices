<?php
	/**
     * Documentation, License etc.
     *
     * @package Webserver
     */
    include_once 'Webserver.php';
    $server = new Webserver();
    echo "{response:".$server->parseRequest()."}";

