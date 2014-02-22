<?php
require_once("webservice.php");
require_once("inc/*.php");

$webClient = initializeObjects();
echo handleWebAccess();

function handleWebAccess(){
	$webClient->showLogin();
}

function initializeObjects(){
	$dsn = 'mysql:dbname=' . $database . ';host='.$address . ';charset=' . DbLayer::CHARSET;
	$pdo = new PDO($dsn, DbLayer::DB_USERNAME, DbLayer::DB_PASSWORD);
	$dataStorage = new MySqlDao($pdo);
	$loginProvider = new LoginProviderImpl($dataStorage);
	$webService = new CreuRojaWebService(ClientType::WEB, $loginProvider);
	return new WebClientImpl($webService);
}

interface WebClient {
	public function showLogin();
	public function getMap($user);
}

class WebClientImpl implements WebClient {
	var $mWebService;
	
	public function __construct(WebService $webService){
		$this->mWebService = $webService;
	}
	
	public function showLogin(){
		
	}
	
	public function showMap(User $user){
		
	}
}