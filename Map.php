<?php
class Map {
	const API_KEY = 'AIzaSyBfi8KVys-Vo9uea-i_IKNMRgfB6EXI5dk';
	const JQUERY = 'https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js';
	const CENTER = 'new google.maps.LatLng(41.3958, 2.1739)';
	const MAP_DEFAULT_ZOOM = '13';
	const MAP_DEFAULT_TYPE = 'google.maps.MapTypeId.ROADMAP';
	public function parseRequest($user) {
		return $this->getMap($user);
	}
	public function getMap($user){
		return '<HTML>' . "\n"
				. $this->writeHead ($user)
				. $this->writeBody ()
				. '</HTML>' . "\n";
	}
	function writeHead($user) {
		return '<HEAD>' . "\n" 
				. '<meta name="viewport" content="initial-scale=1.0, user-scalable=no" '
				. 'charset="utf-8" />'
				. '<link rel="shortcut icon" href="'. $this->getFavIcon() . '"/>' . "\n"
				. '<title>' . $this->getTitle() . '</title>' . "\n"
				. $this->getStyleSheet ()
				. $this->getScripts ($user)
				. '</HEAD>' . "\n";
	}
	function writeBody() {
 		return '<body onload="' . $this->getInitializeMethodName() . '">' . "\n"
				. '  <div id="map_canvas" style="width:100%; height:100%"></div>' . "\n"
 				. '</body>' . "\n";
	}	
	function getFavIcon(){
		return 'favicon.ico';
	}
	function getTitle() {
		return 'Mapa de Creu Roja Barcelona';
	}
	function getStyleSheet() {
		return '<style type="text/css">' . "\n"
				. '  html { height: 100% }' . "\n"
				. '  body { height: 100%; margin: 0; padding: 0 }' . "\n"
				. '  #map_canvas { height: 100% }' . "\n"
				. '</style>' . "\n";
	}
	function getScripts($user) {
		return '<script src="' . self::JQUERY . '"></script>' . "\n"
				. '<script type="text/javascript" src="'
				. $this->getGMapsScript ()
				. '"></script>' . "\n" 
				. $this->getInitializeScript ($user);
	}
	function getGMapsScript() {
		return 'https://maps.googleapis.com/maps/api/js?key=' . self::API_KEY 
				. '&sensor=false';
	}
	function getInitializeScript($user) {
		return '<script type="text/javascript">' . "\n"
				. $this->setMapOptions() 
				. $this->getInitializeMethod ($user)
				. '</script>' . "\n";
	}
	function setMapOptions() {
		return 'google.maps.visualRefresh = true;' . "\n";
	}
	function getInitializeMethod($user) {
		return 'function ' . $this->getInitializeMethodName() . ' {' . "\n"
				. $this->getMapOptions ()
				. $this->getAuxVars ()
				. 'var marcadores=' . $this->loadMarkers ($user) . ';' . "\n"
				. $this->processMarkers ()
				. '}' . "\n";
	}
	function getInitializeMethodName(){
		return "initialize()";
	}
	function getMapOptions() {
		return 'var mapOptions = {' . "\n"
				. '	center: '. self::CENTER . ',' . "\n"
				. '	zoom: ' . self::MAP_DEFAULT_ZOOM . ',' . "\n"
				. '	disableDefaultUI: true,' . "\n"
				. '	mapTypeId: ' . self::MAP_DEFAULT_TYPE . "\n"
				. '};' . "\n";
	}
	function getAuxVars() {
		return 'var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);'
				 . "\n"
				 . 'var infowindow = new google.maps.InfoWindow({content: \'\'});' . "\n";
	}
	function processMarkers() {
		return 'for (var i = 0, j = marcadores.length; i < j; i++) {' . "\n"
				. '  var contenido;' . "\n"
				. '  if (marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_ADDRESS . ' != null && ' 
						. 'marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_OTHER .' != null){' . "\n"
				. '    contenido = ' . $this->loadContent(true) . ';' . "\n"
				. '  } else {'  . "\n"
				. '    contenido = ' . $this->loadContent(false) . "\n"
				. '  }'  . "\n"
				. '	 var marker = new google.maps.Marker({' . "\n"
				. '    position: new google.maps.LatLng(marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_LATITUDE
						. ', marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_LONGITUDE . '),' . "\n"
				. '    map: map,' . "\n"
				. '	   icon: "' . $this->getIconFolder() 
				. '" + marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_TYPE . ' + ".png"' . "\n"
				. '	 });' . "\n"
				. '	 (function(marker, contenido){' . "\n"
				. '	   google.maps.event.addListener(marker, \'click\', function() {' . "\n"
				. '	     infowindow.setContent(contenido);' . "\n"
				. '	     infowindow.open(map, marker);' . "\n"
				. '    });' . "\n"
				. '  })(marker,contenido);' . "\n"
				. '}' . "\n";
	}
	function loadContent($withAddress) {
		if($withAddress){
			return '"<strong>" + marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_NAME . ' + "</strong>"'
				. ' + "<br>" + marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_ADDRESS
				. ' + "<br>" + marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_PHONE
				. ' + "<br>" + marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_OTHER;
		} else {
			return '"<strong>" + marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_NAME . ' + "</strong>"';
		} 
	}
	function getIconFolder() {
		return "icons/";
	}
	function loadMarkers($user) {
		include_once ('LocationsService.php');
		$locationService = new LocationsService();
		return json_encode($locationService->getWebLocations($user));
	}
}
