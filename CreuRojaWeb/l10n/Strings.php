<?php
class Strings{
	const SPANISH = "es";
	const CATALAN = "ca";
	const ENGLISH = "en";

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
	
	var $strings = array(
			self::WEB_TITLE=>array(self::SPANISH=>"Mapa de Cruz Roja Barcelona",
					self::CATALAN=>"Mapa de Creu Roja Barcelona",
					self::ENGLISH=>"Barcelona Red Cross Map"),
			self::E_MAIL=>array(self::SPANISH=>"Correo electrónico",
					self::CATALAN=>"Correu electrònic",
					self::ENGLISH=>"E-Mail"),
			self::PASSWORD=>array(self::SPANISH=>"Contraseña",
					self::CATALAN=>"Contrasenya",
					self::ENGLISH=>"Password"),
			self::LOGIN_BUTTON=>array(self::SPANISH=>"Iniciar sesión",
					self::CATALAN=>"Iniciar sessió",
					self::ENGLISH=>"Log in"),
			self::COOKIES_WARNING=>array(self::SPANISH=>"Este mapa usa cookies para mejorar la experiencia de uso, si inicias sesión entendemos que aceptas el uso de cookies.",
					self::CATALAN=>"Aquest mapa fa servir cookies per millorar l'experiència d'ús, si inicies sessió entenem que acceptes l'ús de cookies.",
					self::ENGLISH=>"This map uses cookies to enhance the user experience, if you log in mean you accept the use of cookies."),
			self::RECOVER_PASSWORD=>array(self::SPANISH=>"¿Ha olvidado su contraseña?",
					self::CATALAN=>"Ha oblidat la seva contrasenya?",
					self::ENGLISH=>"Have you forgotten your password?"),
			self::MENU_SIGN_IN=>array(self::SPANISH=>"Iniciar sesión",
					self::CATALAN=>"Iniciar sessió",
					self::ENGLISH=>"Sign in"),
			self::MENU_SIGN_OUT=>array(self::SPANISH=>"Cerrar sesión",
					self::CATALAN=>"Cerrar sessió",
					self::ENGLISH=>"Sign out"),
			self::MENU_REGISTER_USER=>array(self::SPANISH=>"Registrar nuevo usuario",
					self::CATALAN=>"Registrar nou usuari",
					self::ENGLISH=>"Register new user"),
			self::MENU_MANAGE_LOCATIONS=>array(self::SPANISH=>"Gestionar sitios",
					self::CATALAN=>"Gestionar llocs",
					self::ENGLISH=>"Manage locations"),
			self::MENU_MANAGE_USERS=>array(self::SPANISH=>"Gestionar usuarios",
					self::CATALAN=>"Gestionar usuaris",
					self::ENGLISH=>"Manage users"),
	);

	var $language;

	public function __construct($language = self::CATALAN) {
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