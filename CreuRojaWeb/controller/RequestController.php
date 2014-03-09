<?php
class RequestController{
	var $usersProvider;
	var $locationsProvider;
	public function __construct(UsersProvider $usersProvider, 
			LocationsProvider $locationsProvider){
		$this->usersProvider = $usersProvider;
		$this->locationsProvider = $locationsProvider;
	}
}