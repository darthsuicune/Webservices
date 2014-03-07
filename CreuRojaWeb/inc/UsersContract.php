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

	const ROLE_SOCIAL = "social";
	const ROLE_SOCORROS = "socorros";
	const ROLE_SOCIAL_SOCORROS = "socialsocorros";
	const ROLE_MARITIMOS = "maritimos";
	const ROLE_ADMIN = "admin";
	const ROLE_SOCORROS_MARITIMOS = "socorrosmaritimos";
	const ROLE_REGISTER = "register";
}