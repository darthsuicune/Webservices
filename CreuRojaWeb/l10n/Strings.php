<?php
class Strings{
	const SPANISH = "es";
	const CATALAN = "ca";
	const ENGLISH = "en";

	const WEB_TITLE = "webTitle";
	const E_MAIL = "eMail";
	const PASSWORD = "password";
	const LOGIN = "login";
	const COOKIES_WARNING = "cookiesWarning";
	const RECOVER_PASSWORD = "recoverPassword";

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
			self::LOGIN=>array(self::SPANISH=>"Iniciar sesión",
					self::CATALAN=>"Iniciar sessió",
					self::ENGLISH=>"Log in"),
			self::COOKIES_WARNING=>array(self::SPANISH=>"Al iniciar sesión autoriza el uso de cookies para mejorar la experiencia.",
					self::CATALAN=>"Aquest mapa fa servir cookies per millorar l'experiència sd'ús, si inicies sessió entenem que acceptes l'ús de cookies.",
					self::ENGLISH=>"If you log in you accept the use of cookies from our side."),
			self::RECOVER_PASSWORD=>array(self::SPANISH=>"¿Ha olvidado su contraseña?",
					self::CATALAN=>"Ha oblidat la seva contrasenya?",
					self::ENGLISH=>"Have you forgotten your password?"),
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