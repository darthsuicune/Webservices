<?php
require_once('LoginProvider.php');

interface WebService {
	public function requestAccess($username, $password);
	public function changePassword($user);
	public function recoverPassword($user);
	public function getLastUpdates($user, $lastUpdateTime);
	public function getFullLocationList($user);
}