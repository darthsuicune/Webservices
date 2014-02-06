<?php
require_once("webservice.php");

$adminPanel = new AdminPanel(new WebService);
$adminPanel->handleAdminPanelRequest();

class AdminPanel{
	var $mWebService;
	
	public function __construct($webService){
		$this->mWebService = $webService;
	}
	
	public function handleAdminPanelRequest(){
		
	}
}