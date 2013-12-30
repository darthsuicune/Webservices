<?php
class WebRequest {
	public function parseRequest() {
		echo '<HTML>' . "\n";
		$this->writeHeader ();
 		$this->writeBody ();
		echo '</HTML>' . "\n";
	}
	function writeHeader() {
		echo '<HEAD>' . "\n";
		echo '<meta name="viewport" content="initial-scale=1.0, user-scalable=no" charset="utf-8" />' . "\n";
		echo '<link rel="shortcut icon" href="favicon.ico"/><title>Mapa de Creu Roja Barcelona</title>' . "\n";
 		$this->getStyleSheet ();
 		$this->getScripts ();
		echo '</HEAD>' . "\n";
	}
	function writeBody() {
		echo '<body onload="initialize()">' . "\n";
		echo '<div id="map_canvas" style="width:100%; height:100%"></div>' . "\n";
		echo '</body>' . "\n";
	}
	function getStyleSheet() {
		echo '<style type="text/css">' . "\n";
		echo 'html { height: 100% }' . "\n";
		echo 'body { height: 100%; margin: 0; padding: 0 }' . "\n";
		echo '#map_canvas { height: 100% }' . "\n";
		echo '</style>' . "\n";
	}
	function getScripts() {
		$this->getJQuery ();
		$this->getGMaps ();
		$this->getInitializeScript ();
	}
	function getJQuery() {
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>' . "\n";
	}
	function getGMaps() {
		echo '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBfi8KVys-Vo9uea-i_IKNMRgfB6EXI5dk&sensor=false"></script>' . "\n";
	}
	function getInitializeScript() {
		echo '<script type="text/javascript">' . "\n";
		echo 'google.maps.visualRefresh = true;' . "\n";
		$this->getInitializeMethod ();
		echo '</script>' . "\n";
	}
	function setMapOptions() {
	}
	function getInitializeMethod() {
		echo 'function initialize() {' . "\n";
		$this->getMapOptions ();
		$this->getAuxVars ();
		echo 'var marcadores=' . $this->loadMarkers () . ';' . "\n";
		$this->processMarkers ();
		echo '}' . "\n";
	}
	function getMapOptions() {
		echo 'var mapOptions = {' . "\n";
		echo '	center: new google.maps.LatLng(41.3958, 2.1739),' . "\n";
		echo '	zoom: 12,' . "\n";
		echo '	disableDefaultUI: true,' . "\n";
		echo '	mapTypeId: google.maps.MapTypeId.ROADMAP' . "\n";
		echo '};' . "\n";
	}
	function getAuxVars() {
		echo 'var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);' . "\n";
		echo 'var infowindow = new google.maps.InfoWindow({content: \'\'});' . "\n";
	}
	function processMarkers() {
		echo 'for (var i = 0, j = marcadores.length; i < j; i++) {' . "\n";
		echo '  var contenido;' . "\n";
		echo '  if (marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_ADDRESS . ' != null && ' 
				. 'marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_OTHER .' != null){' . "\n";
		echo '      contenido = ' . $this->loadContent(true) . ';' . "\n";
		echo ' } else {'  . "\n";
		echo '      contenido = ' . $this->loadContent(false) . "\n";
		echo ' }'  . "\n";
		echo '	var marker = new google.maps.Marker({' . "\n";
		echo '		position: new google.maps.LatLng(marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_LATITUDE
				 . ', marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_LONGITUDE . '),' . "\n";
		echo '		map: map,' . "\n";
		echo '		icon: marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_TYPE . ' + ".png"' . "\n";
		echo '	});' . "\n";
		echo '	(function(marker, contenido){' . "\n";
		echo '		google.maps.event.addListener(marker, \'click\', function() {' . "\n";
		echo '			infowindow.setContent(contenido);' . "\n";
		echo '			infowindow.open(map, marker);' . "\n";
		echo '		});' . "\n";
		echo '	})(marker,contenido);' . "\n";
		echo '}' . "\n";
	}
	function loadContent($withAddress) {
		if($withAddress){
			return '"<strong>" + marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_NAME . ' + "</strong>"'
				. ' + "<br>" + marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_ADDRESS
				. ' + "<br>" + marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_OTHER;
		} else {
			return '"<strong>" + marcadores[i].' . LocationsContract::LOCATIONS_COLUMN_NAME . ' + "</strong>"'; 
		} 
	}
	function loadMarkers() {
		include_once ('DbLayer.php');
		$dbLayer = new DbLayer ();
		if ($dbLayer->connect () == DbLayer::RESULT_DB_CONNECTION_ERROR) {
			return null;
		}
		$projection = array (
				LocationsContract::LOCATIONS_COLUMN_LATITUDE,
				LocationsContract::LOCATIONS_COLUMN_LONGITUDE,
				LocationsContract::LOCATIONS_COLUMN_NAME,
				LocationsContract::LOCATIONS_COLUMN_TYPE,
				LocationsContract::LOCATIONS_COLUMN_ADDRESS,
				LocationsContract::LOCATIONS_COLUMN_OTHER,
				LocationsContract::LOCATIONS_COLUMN_LAST_UPDATED 
		);
		$tables = array (
				LocationsContract::LOCATIONS_TABLE_NAME 
		);
		$where = "";
		$whereargs = array ();
		
		$result = $dbLayer->query ( $projection, $tables, $where, $whereargs );
		
		if ($result == null) {
			return null;
		}
		$locationList = array ();
		while ( $row = $result->fetch_assoc () ) {
			$locationList [] = new Location ( $row );
		}
		
		$dbLayer->close ();
		return json_encode ( $locationList );
	}
}