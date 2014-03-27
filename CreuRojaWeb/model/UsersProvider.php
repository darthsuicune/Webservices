<?php
require_once('DataStorage.php');

interface UsersProvider {
	public function getUserFromEmail($email);
	public function getUserFromAccessToken($accessToken);
}