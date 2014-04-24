<?php
class ClientConfiguration{
	const DB_ADDRESS = 'localhost'; // TODO: Set values
	const DB_USERNAME = 'testuser'; // TODO: Set values
	const DB_PASSWORD = 'testpass'; // TODO: Set values
	const DB_DATABASE = 'webservice';
	const CHARSET = 'UTF8';

	const ANDROID = 1;
	const WEB = 2;

	public function getClient($clientType){
		$dsn = "mysql:dbname=" . self::DB_DATABASE . ";host=" . self::DB_ADDRESS
		. ";charset=" . self::CHARSET;
		$pdo = new PDO($dsn, self::DB_USERNAME, self::DB_PASSWORD);
		$dataStorage = new MySqlDao($pdo);
		$usersProvider = new UsersProviderImpl($dataStorage);
		$locationsProvider = new LocationsProviderImpl($dataStorage);
		$usersController = new UsersControllerImpl($usersProvider);
		$locationsController = new LocationsControllerImpl($locationsProvider);

		switch($clientType){
			case self::ANDROID:
				return new AndroidClient($usersController, $locationsController);
			case self::WEB:
				$sessionsController = new SessionsControllerImpl($dataStorage);
				$strings = new Strings(Strings::LANG_ENGLISH);
				return new WebClient($usersController, $locationsController, $sessionsController, $strings);
			default:
				return false;
		}

	}
}