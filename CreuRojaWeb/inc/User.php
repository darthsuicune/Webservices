<?php
class User{
	var $id;
	var $email;
	var $role;
	
	public function __construct($email, $role, $id = 0 ){
		$this->id = $id;
		$this->email = $email;
		$this->role = $role;
	}
}