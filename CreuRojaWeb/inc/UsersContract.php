<?php
class UsersContract {
	/**
	 * Users table
	 */
	const USERS_TABLE_NAME = "users";
	const USERS_COLUMN_ID = "id";
	const USERS_COLUMN_USERNAME = "username";
	const USERS_COLUMN_PASSWORD = "password";
	const USERS_COLUMN_E_MAIL = "email";
	const USERS_COLUMN_ROLE = "role";

	const ROLE_SOCIAL = "social";
	const ROLE_SOCORROS = "socorros";
	const ROLE_SOCIAL_SOCORROS = "socialsocorros";
	const ROLE_MARITIMOS = "maritimos";
	const ROLE_ADMIN = "admin";
	const ROLE_SOCORROS_MARITIMOS = "socorrosmaritimos";
	const ROLE_REGISTER = "registrador";
}