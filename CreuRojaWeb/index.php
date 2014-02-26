<?php
require_once("webservice.php");

$webClient = initializeObjects();
echo handleWebAccess();

function handleWebAccess(){
	$webClient->showLogin();
}

const DB_ADDRESS = 'localhost'; // TODO: Set values
const DB_USERNAME = 'wait'; // TODO: Set values
const DB_PASSWORD = 'wat'; // TODO: Set values
const DB_DATABASE = 'webservice';
const CHARSET = 'UTF8';

function initializeObjects(){
	$dsn = 'mysql:dbname=' . $database . ';host='.$address . ';charset=' . self::CHARSET;
	$pdo = new PDO($dsn, self::DB_USERNAME, self::DB_PASSWORD);
	$dataStorage = new MySqlDao($pdo);
	$loginProvider = new LoginProviderImpl($dataStorage);
	$webService = new CreuRojaWebService(ClientType::WEB, $loginProvider);
	return new WebClientImpl($webService);
}

