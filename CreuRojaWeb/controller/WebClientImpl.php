<?php

class WebClientImpl implements WebClient {
	var $webService;

	public function __construct(WebService $webService){
		$this->webService = $webService;
	}

	public function showLogin(){

	}

	public function showMap(User $user){

	}
}