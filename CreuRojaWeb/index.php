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
require_once('ClientConfiguration.php');
require_once('WebClient.php');

const REQUEST_LOGIN = "login";
const REQUEST_LOGOUT = "logout";
const REQUEST_UPDATE_LOCATION = "update";
const REQUEST_ADD_LOCATION = "addNew";
const REQUEST_DELETE_LOCATION = "delete";
const REQUEST_REGISTER = "register";
const REQUEST_CHANGE_PASSWORD = "changePassword";
const REQUEST_RECOVER_PASSWORD = "recoverPassword";
const REQUEST_ABOUT = "about";
const REQUEST_CONTACT = "contact";
const REQUEST_TYPE = "q";

session_start();

$language = Strings::LANG_ENGLISH; //TODO get the language

$clientConfig = new ClientConfiguration();
$webClient = $clientConfig->getClient(ClientConfiguration::WEB, $language);

$request[0] = false;
if(isset($_GET[REQUEST_TYPE])){
	$request = explode("/", $_GET[REQUEST_TYPE]);
}
if(isset($request[1])){
	switch($request[0]){
		case REQUEST_UPDATE_LOCATION:
			$webClient->handleLocationUpdateRequest($request[1]);
			break;
		case REQUEST_DELETE_LOCATION:
			$webClient->handleLocationDeleteRequest($request[1]);
			break;
		default:
			$webClient->showRoot();
			break;
	}
} else {
	switch($request[0]){
		case REQUEST_LOGIN:
			$webClient->handleLoginRequest();
			break;
		case REQUEST_LOGOUT:
			$webClient->handleLogoutRequest();
			break;
		case REQUEST_ADD_LOCATION:
			$webClient->handleLocationAddRequest();
			break;
		case REQUEST_REGISTER:
			$webClient->handleRegisterRequest();
			break;
		case REQUEST_CHANGE_PASSWORD:
			$webClient->handlePasswordChangeRequest();
			break;
		case REQUEST_RECOVER_PASSWORD:
			$webClient->handlePasswordRecoverRequest();
			break;
		case REQUEST_ABOUT:
			$webClient->handleAboutRequest();
			break;
		case REQUEST_CONTACT:
			$webClient->handleContactRequest();
			break;
		default:
			$webClient->showRoot();
			break;
	}
}