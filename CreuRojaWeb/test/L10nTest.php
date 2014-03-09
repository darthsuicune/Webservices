<?php
function testLocalization(){
	echo "<td> Localization tests";
	echo "<td>testGetWebTitle<br>\n";
	echo testGetWebTitle();
// 	echo "</td><td>testGetWebTitle (ES)<br>\n";
	echo "</td>";
}

function testGetWebTitle(){
	$strings = new Strings();
	assertEquals("Web Title (ES)", $strings->get(Strings::WEB_TITLE, Strings::SPANISH), "Mapa de Cruz Roja Barcelona");
	assertEquals("Web Title (EN)", $strings->get(Strings::WEB_TITLE, Strings::ENGLISH), "Barcelona Red Cross Map");
	assertEquals("Web Title (CA)", $strings->get(Strings::WEB_TITLE), "Mapa de Creu Roja Barcelona");
}