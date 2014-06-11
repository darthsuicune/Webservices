<?php
class Strings{
	const LANG_SPANISH = "es";
	const LANG_CATALAN = "ca";
	const LANG_ENGLISH = "en";

	const WEB_TITLE = "webTitle";
	const E_MAIL = "eMail";
	const PASSWORD = "password";
	const LOGIN_BUTTON = "login";
	const COOKIES_WARNING = "cookiesWarning";
	const RECOVER_PASSWORD = "recoverPassword";

	const MENU_SIGN_IN = "signIn";
	const MENU_SIGN_OUT = "signOut";
	const MENU_REGISTER_USER = "registerUser";
	const MENU_MANAGE_LOCATIONS = "manageLocations";
	const MENU_MANAGE_USERS = "manageUsers";

	const MENU_CONTACT = "contact";
	const MENU_ABOUT = "about";

	const TITLE_CONTACT = "titleContact";
	const TITLE_ABOUT = "titleAbout";

	const ERRORS_TITLE = "errorsTitle";
	const ERROR_INVALID_LOGIN = "errorInvalidLogin";
	const ERROR_NO_LOGIN = "errorNoLogin";
	const ERROR_UNAUTHORIZED = "errorUnauthorized";

	const NOTICE_TITLE = "noticeTitle";
	const LOGOUT_MESSAGE = "logoutMessage";

	const INSTALL_TITLE = "installTitle";
	const INSTALL_ADDRESS = "installAddress";
	const INSTALL_BUTTON = "installButton";
	const INSTALL_DATABASE = "installDatabase";
	const INSTALL_USERNAME = "installUsername";
	const INSTALL_PASSWORD = "installPassword";
	const INSTALL_CONFIRM_PASSWORD = "installConfirmPassword";

	const INSTALL_ERROR_EMPTY_ADDRESS = "installEmptyAddress";
	const INSTALL_ERROR_EMPTY_DATABASE = "installEmptyDatabase";
	const INSTALL_ERROR_EMPTY_USERNAME = "installEmptyUsername";
	const INSTALL_ERROR_EMPTY_PASSWORD = "installEmptyPassword";
	const INSTALL_ERROR_EMPTY_PASSWORD_CONFIRMATION = "installEmptyPasswordConfirmation";
	const INSTALL_ERROR_PASSWORDS_DONT_MATCH = "installPasswordsDontMatch";
	const INSTALL_ERROR_CANNOT_CONNECT = "installCantConnect";

	var $strings;
	var $language;

	public function __construct($language = Strings::LANG_CATALAN) {
		$this->language = $language;
		require("$language.php");
		$this->strings = $strings;
	}

	/**
	 *
	 * @param unknown_type $language
	 * @return multitype:multitype:string
	 */
	public function get($string) {
		return $this->strings[$string];
	}

	public static function getDefaultLanguage() {
		switch(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2)){
			case self::LANG_ENGLISH:
				return Strings::LANG_ENGLISH;
			default:
				return Strings::LANG_CATALAN;
		}
	}
}