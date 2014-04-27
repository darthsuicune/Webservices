<?php
foreach (glob("controller/*.php") as $filename)
{
	require_once($filename);
}
foreach (glob("model/*.php") as $filename)
{
	require_once($filename);
}
foreach (glob("l10n/*.php") as $filename)
{
	require_once($filename);
}
foreach (glob("db/*.php") as $filename)
{
	require_once($filename);
}
foreach (glob("view/*.php") as $filename)
{
	require_once($filename);
}
foreach (glob("view/static/*.php") as $filename)
{
	require_once($filename);
}

require_once('ClientConfiguration.php');
require_once('WebClient.php');

const REQUEST_TYPE = "q";

if(isset($_COOKIE['PHPSESSID'])) {
	session_start();
}

$language = Strings::getDefaultLanguage();

$clientConfig = new ClientConfiguration();
$webClient = $clientConfig->getClient(ClientConfiguration::WEB, $language);

handleRequest($webClient);

function handleRequest($webClient){
	$request = false;
	if(isset($_GET[REQUEST_TYPE])){
		$request = $_GET[REQUEST_TYPE];
	}
	switch($request){
		case Actions::ABOUT:
			$webClient->showAbout();
			break;
		case Actions::CONTACT:
			$webClient->showContact();
			break;
		case Actions::LOGOUT:
			$webClient->handleLogoutRequest();
			break;
		default:
			if(isset($_SESSION[SessionsController::USER])) {
				$user = $_SESSION[SessionsController::USER];
				return handleUserRequest($webClient, $request, $user);
			} else {
				return $webClient->handleLoginRequest();
			}
	}
}

function handleUserRequest(WebClient $webClient, $request, User $user) {
	$lang = $_SESSION[SessionsController::LANGUAGE];

	if($user->isAllowedTo($request[0])){
		switch($request[0]){
			case Actions::UPDATE_LOCATION:
				return $webClient->handleLocationUpdateRequest($request[1]);
			case Actions::DELETE_LOCATION:
				return $webClient->handleLocationDeleteRequest($request[1]);
			case Actions::MANAGE_LOCATIONS:
				return $webClient->handleLocationManagementRequest();
			case Actions::MANAGE_USERS:
				return $webClient->handleUserManagementRequest();
			case Actions::REGISTER:
				return $webClient->handleRegisterRequest();
			case Actions::ADD_LOCATION:
				return $webClient->handleLocationAddRequest();
			case Actions::CHANGE_PASSWORD:
				return $webClient->handlePasswordChangeRequest();
			case Actions::RECOVER_PASSWORD:
				return $webClient->handlePasswordRecoverRequest();
			case Actions::MAP:
				return $webClient->showMap();
			default:
				$notice = new Notice(array(Notice::NOTICE_TYPE_ERROR,
				$lang->get(Strings::ERROR_UNAUTHORIZED)));
				return $webClient->showDefaultView($user);
		}
	} else {
		$notice = new Notice(array(Notice::NOTICE_TYPE_ERROR,
				$lang->get(Strings::ERROR_UNAUTHORIZED)));
		return $webClient->showDefaultView($user);
	}
}