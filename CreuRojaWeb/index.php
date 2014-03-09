<?php
require_once('model/MySqlDao.php');
require_once('model/UsersProviderImpl.php');

require_once("ClientConfiguration.php");
require_once("controller/WebClient.php");
require_once("controller/WebClientImpl.php");
require_once("controller/RequestController.php");

require_once("l10n/languages.php");

class MockController extends RequestController {
	public function __construct(){

	}
}

$clientConfig = new ClientConfiguration();
$webClient = new WebClientImpl(new MockController());
echo $webClient->handleRequest();
