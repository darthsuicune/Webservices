<?php
class Strings{
	const SPANISH = "es";
	const CATALAN = "ca";
	const ENGLISH = "en";

	const WEB_TITLE = "WebTitle";

	var $strings = array(self::WEB_TITLE=>array(self::SPANISH=>"Mapa de Cruz Roja Barcelona",
			self::CATALAN=>"Mapa de Creu Roja Barcelona",
			self::ENGLISH=>"Barcelona Red Cross Map")

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
		$strings = self::getStrings($string);
		return $strings[$this->language];
	}

	function getStrings($string){
		return $this->strings[$string];
	}
}