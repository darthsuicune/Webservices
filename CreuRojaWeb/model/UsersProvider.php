<?php
require_once('DataStorage.php');

interface UsersProvider {
	public function getUserFromEmail($email);
	public function getUserFromLoginData($email, $password);
	public function getUserFromAccessToken($accessToken);
	public function getUserList(array $roles);
}