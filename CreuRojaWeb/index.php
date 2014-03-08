<?php
require_once("controller/WebClient.php");
require_once("controller/WebClientImpl.php");

$webClient = new WebClientImpl();
$webClient->handleRequest();

const DB_ADDRESS = 'localhost'; // TODO: Set values
const DB_USERNAME = 'testuser'; // TODO: Set values
const DB_PASSWORD = 'testpass'; // TODO: Set values
const DB_DATABASE = 'webservice';
const CHARSET = 'UTF8';

function initializeObjects(){
	$dsn = 'mysql:dbname=' . $database . ';host='.$address . ';charset=' . self::CHARSET;
	$pdo = new PDO($dsn, self::DB_USERNAME, self::DB_PASSWORD);
	$dataStorage = new MySqlDao($pdo);
	$loginProvider = new LoginProviderImpl($dataStorage);
	$webService = new CreuRojaWebService($loginProvider);
	return new WebClientImpl($webService);
}

