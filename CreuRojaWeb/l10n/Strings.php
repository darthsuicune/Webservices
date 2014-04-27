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
	
	var $strings = array(
			self::WEB_TITLE=>array(self::LANG_SPANISH=>"Mapa de Cruz Roja Barcelona",
					self::LANG_CATALAN=>"Mapa de Creu Roja Barcelona",
					self::LANG_ENGLISH=>"Barcelona Red Cross Map"),
			self::E_MAIL=>array(self::LANG_SPANISH=>"Correo electrónico",
					self::LANG_CATALAN=>"Correu electrònic",
					self::LANG_ENGLISH=>"E-Mail"),
			self::PASSWORD=>array(self::LANG_SPANISH=>"Contraseña",
					self::LANG_CATALAN=>"Contrasenya",
					self::LANG_ENGLISH=>"Password"),
			self::LOGIN_BUTTON=>array(self::LANG_SPANISH=>"Iniciar sesión",
					self::LANG_CATALAN=>"Iniciar sessió",
					self::LANG_ENGLISH=>"Log in"),
			self::COOKIES_WARNING=>array(self::LANG_SPANISH=>"Esta página usa cookies para mejorar la experiencia de uso, si inicias sesión entendemos que aceptas el uso de cookies.",
					self::LANG_CATALAN=>"Aquest mapa fa servir cookies per millorar l'experiència d'ús, si inicies sessió entenem que acceptes l'ús de cookies.",
					self::LANG_ENGLISH=>"This webpage uses cookies to enhance the user experience, if you log in mean you accept the use of cookies."),
			self::RECOVER_PASSWORD=>array(self::LANG_SPANISH=>"¿Ha olvidado su contraseña?",
					self::LANG_CATALAN=>"Ha oblidat la seva contrasenya?",
					self::LANG_ENGLISH=>"Have you forgotten your password?"),
			self::MENU_SIGN_IN=>array(self::LANG_SPANISH=>"Iniciar sesión",
					self::LANG_CATALAN=>"Iniciar sessió",
					self::LANG_ENGLISH=>"Sign in"),
			self::MENU_SIGN_OUT=>array(self::LANG_SPANISH=>"Cerrar sesión",
					self::LANG_CATALAN=>"Cerrar sessió",
					self::LANG_ENGLISH=>"Sign out"),
			self::MENU_REGISTER_USER=>array(self::LANG_SPANISH=>"Registrar nuevo usuario",
					self::LANG_CATALAN=>"Registrar nou usuari",
					self::LANG_ENGLISH=>"Register new user"),
			self::MENU_MANAGE_LOCATIONS=>array(self::LANG_SPANISH=>"Gestionar sitios",
					self::LANG_CATALAN=>"Gestionar llocs",
					self::LANG_ENGLISH=>"Manage locations"),
			self::MENU_MANAGE_USERS=>array(self::LANG_SPANISH=>"Gestionar usuarios",
					self::LANG_CATALAN=>"Gestionar usuaris",
					self::LANG_ENGLISH=>"Manage users"),
			self::MENU_ABOUT=>array(self::LANG_SPANISH=>"Sobre nosotros",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"About"),
			self::MENU_CONTACT=>array(self::LANG_SPANISH=>"Contacto",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"Contact"),
			self::TITLE_ABOUT=>array(self::LANG_SPANISH=>"Sobre nosotros",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"About"),
			self::TITLE_CONTACT=>array(self::LANG_SPANISH=>"Contacto",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"Contact"),
			self::NOTICE_TITLE=>array(self::LANG_SPANISH=>"Información:",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"Information:"),
			self::ERRORS_TITLE=>array(self::LANG_SPANISH=>"Se han encontrado errores al procesar el formulario:",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"Errors were found when processing the form:"),
			self::ERROR_INVALID_LOGIN=>array(self::LANG_SPANISH=>"La dirección de correo o contraseña son incorrectos",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"E-mail address or password are incorrect."),
			self::ERROR_NO_LOGIN=>array(self::LANG_SPANISH=>"La dirección de correo y contraseña son obligatorios",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"E-mail address and password are mandatory."),
			self::ERROR_UNAUTHORIZED=>array(self::LANG_SPANISH=>"No está autorizado a hacer esa acción.",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"You aren't authorized to perform such action."),
			self::LOGOUT_MESSAGE=>array(self::LANG_SPANISH=>"Sesión cerrada correctamente.",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"Successfully logged out."),
			self::INSTALL_TITLE=>array(self::LANG_SPANISH=>"Instalación",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"Installation"),
			self::INSTALL_ADDRESS=>array(self::LANG_SPANISH=>"Dirección de la base de datos",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"Address of the database"),
			self::INSTALL_BUTTON=>array(self::LANG_SPANISH=>"Confirmar",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"Confirm"),
			self::INSTALL_DATABASE=>array(self::LANG_SPANISH=>"Nombre de la base de datos",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"Database name"),
			self::INSTALL_PASSWORD=>array(self::LANG_SPANISH=>"Contraseña del usuario de la base de datos",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"Database user password"),
			self::INSTALL_CONFIRM_PASSWORD=>array(self::LANG_SPANISH=>"Confirmar contraseña del usuario de la base de datos",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"Confirm database user password"),
			self::INSTALL_USERNAME=>array(self::LANG_SPANISH=>"Nombre del usuario de la base de datos",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"Database user name"),
			self::INSTALL_ERROR_EMPTY_ADDRESS=>array(self::LANG_SPANISH=>"La dirección de la base de datos no puede estar vacío",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"The database address cannot be empty."),
			self::INSTALL_ERROR_EMPTY_DATABASE=>array(self::LANG_SPANISH=>"El nombre de la base de datos no puede estar vacío",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"The database name cannot be empty."),
			self::INSTALL_ERROR_EMPTY_PASSWORD=>array(self::LANG_SPANISH=>"La contraseña del usuario de la base de datos no puede estar vacío",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"The password cannot be empty."),
			self::INSTALL_ERROR_EMPTY_PASSWORD_CONFIRMATION=>array(self::LANG_SPANISH=>"La confirmación de contraseña del usuario de la base de datos no puede estar vacío",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"The password confirmation cannot be empty."),
			self::INSTALL_ERROR_EMPTY_USERNAME=>array(self::LANG_SPANISH=>"Nombre del usuario de la base de datos no puede estar vacío",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"The database user name cannot be empty."),
			self::INSTALL_ERROR_PASSWORDS_DONT_MATCH=>array(self::LANG_SPANISH=>"La contraseña y su confirmación no coinciden",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"The password and its confirmation don't match"),
			self::INSTALL_ERROR_CANNOT_CONNECT=>array(self::LANG_SPANISH=>"No se pudo establecer la conexión con la base de datos",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"Can't connect to the database."),
	);

	var $language;

	public function __construct($language = self::LANG_CATALAN) {
		$this->language = $language;
	}

	/**
	 *
	 * @param unknown_type $language
	 * @return multitype:multitype:string
	 */
	public function get($string) {
		$strings = $this->strings[$string];
		return $strings[$this->language];
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