<?php
class UsersContract {
	/**
	 * Users table
	 */
	const TABLE_NAME = "users";
	const COLUMN_ID = "id";
	const COLUMN_NAME = "name";
	const COLUMN_SURNAME = "surname";
	const COLUMN_PASSWORD = "password";
	const COLUMN_E_MAIL = "email";
	const COLUMN_ROLE = "role";
	const COLUMN_LANGUAGE = "language";
	const COLUMN_PASSWORD_RESET_TOKEN = "resettoken";
	const COLUMN_PASSWORD_RESET_TIME = "resettime";

	const ROLE_SOCIAL = "social";
	const ROLE_SOCORROS = "socorros";
	const ROLE_SOCIAL_SOCORROS = "socialsocorros";
	const ROLE_MARITIMOS = "maritimos";
	const ROLE_ADMIN = "admin";
	const ROLE_SOCORROS_MARITIMOS = "socorrosmaritimos";
	const ROLE_REGISTER = "register";
	
	static function getRoles(){
		return array(self::ROLE_SOCIAL,
				self::ROLE_SOCORROS,
				self::ROLE_SOCIAL_SOCORROS,
				self::ROLE_MARITIMOS,
				self::ROLE_ADMIN,
				self::ROLE_SOCORROS_MARITIMOS,
				self::ROLE_REGISTER);
	}
}