<?php class LocationManager implements Content {
	public function showContent(Notice $notices = null) {
		?>
<div id="location_manager"></div>
<?php 
require_once('footer.php');
	}

	public function getHtmlHeaders() { ?>
<link href="view/css/locationmanager.css" rel="stylesheet" type="text/css" />
<?php 
	}
}?>