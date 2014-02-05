<?php
require_once("webservice.php");

$index = new WebClient(new WebService(ClientType::WEB));
$index->handleWebAccess();

class WebClient{
	var $mWebService;
	
	public function __construct(WebService $webService){
		$this->mWebService = $webService;
	}
	
	public function handleWebAccess(){
		
	}
}

interface WebService {
	public function requestAccess();
	public function changePassword();
	public function recoverPassword();
	public function getLastUpdates();
	public function getFullLocationList();
}