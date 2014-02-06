<?php
require_once("webservice.php");

$androidConnection = new WebService(ClientType::ANDROID);
$androidConnection->handleAndroidConnection();

interface AndroidClient {
}
class AndroidClientImpl{
	var $mWebService;
	
	public function __construct(WebService $webService){
		$this->mWebService = $webService;
	}
	
}