<?php
require_once('WebClient.php');

class WebClientImpl implements WebClient {
	var $requestController;

	public function __construct(RequestController $requestController){
		$this->requestController = $requestController;
	}

	public function handleRequest() {

	}
}