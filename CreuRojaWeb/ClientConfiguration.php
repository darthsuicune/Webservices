<?php
class ClientConfiguration{

	const ANDROID = 1;
	const WEB = 2;

	public function getClient($clientType, $lang = Strings::LANG_CATALAN){
		require_once("config.php");
		$dsn = "mysql:dbname=$DB_DATABASE;host=$DB_ADDRESS;charset=$CHARSET";
		$pdo = new PDO($dsn, $DB_USERNAME, $DB_PASSWORD);
		$dataStorage = new MySqlDao($pdo);
		$usersProvider = new UsersProviderImpl($dataStorage);
		$locationsProvider = new LocationsProviderImpl($dataStorage);
		$usersController = new UsersControllerImpl($usersProvider);
		$locationsController = new LocationsControllerImpl($locationsProvider);

		switch($clientType){
			case self::ANDROID:
				return new AndroidClient($usersController, $locationsController);
			case self::WEB:
				require_once("view/root.php");
				$sessionsController = new SessionsControllerImpl($dataStorage);
				$sessionsController->setLanguage($lang);
				$user = null;
				if(isset($_SESSION[SessionsController::USER])){
					$user = $_SESSION[SessionsController::USER];
				}
				$root = new Root($user);
				return new WebClient($usersController, $locationsController, $sessionsController, $root);
			default:
				return false;
		}

	}
}