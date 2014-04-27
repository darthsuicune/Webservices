<?php class Map implements Content{
	public function showContent(Notice $notices = null) {
		$header = new Header();
		$header->showHeader($_SESSION[SessionsController::USER]);
		?>
<div id="map-canvas"></div>
<?php }

public function getHtmlHeaders() {
	require_once('scripts/gmaps.php');
}
}?>