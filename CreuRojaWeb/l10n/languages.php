<?php
class Strings{
	const ES = "es";
	const CA = "ca";
	const EN = "en";
	
	const WEB_TITLE = "WebTitle";

	function getString($language = self::CA) {
		return array(self::WEB_TITLE=>array(self::SPANISH=>"",
				self::CATALAN=>"",
				self::ENGLISH=>""),
				
		);
	}
}