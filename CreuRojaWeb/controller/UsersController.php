<?php

interface UsersController {
	public function getUserFromEmail($email);
	public function validateUserFromLoginData($email, $password);
	public function validateUserFromAccessToken($accessToken);
}