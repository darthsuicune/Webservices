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
			self::COOKIES_WARNING=>array(self::LANG_SPANISH=>"Este mapa usa cookies para mejorar la experiencia de uso, si inicias sesión entendemos que aceptas el uso de cookies.",
					self::LANG_CATALAN=>"Aquest mapa fa servir cookies per millorar l'experiència d'ús, si inicies sessió entenem que acceptes l'ús de cookies.",
					self::LANG_ENGLISH=>"This map uses cookies to enhance the user experience, if you log in mean you accept the use of cookies."),
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
			self::ERRORS_TITLE=>array(self::LANG_SPANISH=>"Se han encontrado errores al procesar el formulario:",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"Errors were found when processing the form:"),
			self::ERROR_INVALID_LOGIN=>array(self::LANG_SPANISH=>"La dirección de correo o contraseña son incorrectos",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"E-mail address or password are incorrect."),
			self::ERROR_NO_LOGIN=>array(self::LANG_SPANISH=>"La dirección de correo y contraseña son obligatorios",
					self::LANG_CATALAN=>"",
					self::LANG_ENGLISH=>"E-mail address and password are mandatory."),
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
}