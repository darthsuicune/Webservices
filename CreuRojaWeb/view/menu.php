<?php class Menu {
	public function showMenu(User $user = null) {
		$lang = $_SESSION[SessionsController::LANGUAGE];
		?>
<div class="nav_menu">
	<ul>
		<?php 
		if($user) {
			if($user->isAllowedTo(Actions::MAP)) {
				?>
		<li><a href="index.php?q=map">Map</a>
		</li>
		<?php } 
			if($user->isAllowedTo(Actions::REGISTER_USER)) { ?>

		<li><a href="index.php?q=register"> <?php echo $lang->get(Strings::MENU_REGISTER_USER); ?>
		</a></li>
		<?php } 
			if($user->isAllowedTo(Actions::MANAGE_LOCATIONS)) { ?>
		<li><a href="index.php?q=manageLocations"> <?php echo $lang->get(Strings::MENU_MANAGE_LOCATIONS); ?>
		</a></li>
		<?php } 
			if($user->isAllowedTo(Actions::MANAGE_USERS)) { ?>
		<li><a href="index.php?q=manageUsers"> <?php echo $lang->get(Strings::MENU_MANAGE_USERS); ?>
		</a></li>
		<?php 
			} ?>

		<li><a href="index.php?q=logout"> <?php echo $lang->get(Strings::MENU_SIGN_OUT); ?>
		</a></li>
		<?php 
		} else { ?>

		<li><a href="index.php?q=login"> <?php echo $lang->get(Strings::MENU_SIGN_IN); ?>
		</a></li>
		<?php } ?>

	</ul>
</div>

<?php }
}?>