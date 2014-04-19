<?php
$API_KEY = 'AIzaSyBfi8KVys-Vo9uea-i_IKNMRgfB6EXI5dk';
$CENTER = 'new google.maps.LatLng(41.3958, 2.1739)';
$MAP_DEFAULT_ZOOM = '13';
$MAP_DEFAULT_TYPE = 'google.maps.MapTypeId.ROADMAP';

function getGmapsScript() {
	return "https://maps.googleapis.com/maps/api/js?key=$API_KEY&sensor=false";
}


?>
<script type="text/javascript" src="<?php echo getGmapsScript(); ?>"></script> 
<script type="text/javascript">
google.maps.visualRefresh = true; 
function initialize() {
	var mapOptions = {
			center: <?php echo $CENTER; ?>,
			zoom: <?php echo $MAP_DEFAULT_ZOOM; ?>,
			disableDefaultUI: true,
			mapTypeId: <?php echo $MAP_DEFAULT_TYPE; ?>
	};
	var marcadores="<?php echo $_SESSION['markers'];?>";
	var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	var infowindow = new google.maps.InfoWindow({content: ''});

	for (var i = 0, j = marcadores.length; i < j; i++) {
		var contenido;
		  
		if (marcadores[i].<?php echo LocationsContract::COLUMN_ADDRESS; ?>  != null && 
				marcadores[i].<?php echo LocationsContract::COLUMN_OTHER; ?> != null){
			contenido = "<strong>" + marcadores[i].<?php echo LocationsContract::COLUMN_NAME; ?> + "</strong>"
					+ "<br>" + marcadores[i].<?php echo LocationsContract::LOCATIONS_COLUMN_ADDRESS; ?>
					+ "<br>" + marcadores[i].<?php echo LocationsContract::LOCATIONS_COLUMN_OTHER; ?>;
		} else {
			contenido = "<strong>" + marcadores[i].<?php echo LocationsContract::COLUMN_NAME; ?> + "</strong>";
		}
		
		var marker = new google.maps.Marker({
		    position: new google.maps.LatLng(marcadores[i].<?php echo LocationsContract::COLUMN_LATITUDE; ?>, 
				    marcadores[i].<?php echo LocationsContract::COLUMN_LONGITUDE; ?> ),
		    map: map,
			icon: "icons/" + marcadores[i].<?php echo LocationsContract::COLUMN_TYPE; ?> + ".png"
			 });
			 (function(marker, contenido){
			   google.maps.event.addListener(marker, 'click', function() {
			     infowindow.setContent(contenido);
			     infowindow.open(map, marker);
		   });
		})(marker,contenido);
	}
}
</script>
