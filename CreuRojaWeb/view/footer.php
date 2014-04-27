<?php class Footer {

	public function showFooter() {
		?>
<div id="footer">
	<hr />
	<ul>
		<li><a href="?q=contact"><?php echo $_SESSION[SessionsController::LANGUAGE]->get(Strings::MENU_CONTACT); ?>
		</a>
		</li>
		<li><a href="?q=about"><?php echo $_SESSION[SessionsController::LANGUAGE]->get(Strings::MENU_ABOUT); ?>
		</a>
		</li>
	</ul>
</div>
<?php }
}?>
