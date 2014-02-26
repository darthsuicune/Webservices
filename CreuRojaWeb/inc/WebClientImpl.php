<?php

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