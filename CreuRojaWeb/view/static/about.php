<?php class About implements Content {
	public function showContent(Notice $notice = null) {
		$header = new Header();
		$header->showHeader();
		?>
<div id="content">
	<h1>
		<?php echo $_SESSION[SessionsController::LANGUAGE]->get(Strings::TITLE_ABOUT) ?>
	</h1>
	<hr />
</div>
<?php 
$footer = new Footer();
$footer->showFooter(true);
	}
	
	public function getHtmlHeaders() { ?>
<meta content="text/html; charset=UTF-8" http-equiv="content-type" />
	<?php }
}?>