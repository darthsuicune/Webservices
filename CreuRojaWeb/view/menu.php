<div class="nav_menu">
	<ul>
		<?php if($user) {
			if($user->isAllowedTo(Actions::SEE_MAP)) { ?>
				<li><a href="index.php?q=map">Map</a> 
			<?php } if($user->isAllowedTo(Actions::MENU_MANAGEMENT)) { ?>
			
				<li><a href="index.php?q=register">
				<?php echo $languages->get(Strings::MENU_REGISTER_USER); ?> </a>
				
				<li><a href="index.php?q=manageLocations">
				<?php echo $languages->get(Strings::MENU_MANAGE_LOCATIONS); ?> </a>
				
				<li><a href="index.php?q=manageUsers">
				<?php echo $languages->get(Strings::MENU_MANAGE_LOCATIONS); ?> </a> 
			<?php } ?>
			
			<li><a href="index.php?q=logout">
			<?php echo $languages->get(Strings::MENU_SIGN_OUT); ?> </a> 
		<?php } else { ?>
			
			<li><a href="index.php?q=login">
			<?php echo $languages->get(Strings::MENU_SIGN_IN); ?> </a> 
		<?php } ?>
	
	</ul>
</div>
