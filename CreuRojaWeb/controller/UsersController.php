<?php

interface UsersController {
	public function validateUserFromLogin($email, $password);
	public function validateUserFromAccessToken($accessToken);
}