<?php
require_once('DataStorage.php');

interface UsersProvider {
	public function validateUserInfo($email, $password);
	public function validateAccessToken($accessToken);
}