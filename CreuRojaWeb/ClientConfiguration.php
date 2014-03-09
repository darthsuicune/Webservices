<?php
class ClientConfiguration{
	const DB_ADDRESS = 'localhost'; // TODO: Set values
	const DB_USERNAME = 'testuser'; // TODO: Set values
	const DB_PASSWORD = 'testpass'; // TODO: Set values
	const DB_DATABASE = 'webservice';
	const CHARSET = 'UTF8';
	
	public function getRequestController(){
		$dsn = "mysql:dbname=".self::DB_DATABASE.";host=".self::DB_ADDRESS.";charset=" . self::CHARSET;
		$pdo = new PDO($dsn, self::DB_USERNAME, self::DB_PASSWORD);
		$dataStorage = new MySqlDao($pdo);
		$usersProvider = new UsersProviderImpl($dataStorage);
		$locationsProvider = new LocationsProviderImpl($dataStorage);
		return new RequestController($usersProvider, $locationsProvider);
	}
}