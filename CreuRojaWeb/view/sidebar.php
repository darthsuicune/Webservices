<div class="sidebar">
	<ul>
		<?php 
			if ($user) {
				echo '<li><a href="index.php?q=logout">Sign out</a>';
			} else {
				echo '<li><a href="index.php?q=login">Sign in</a>';
			}
		?>
		<li><a href="index.php?q=map">Map</a> 
		<?php 
			if ($user && $user->isAllowedTo(Acctions::SIDEBAR_MANAGEMENT)) {
				echo '<li><a href="index.php?q=register">Register new user</a>';
			} else if ($user) {
				echo '<li><a href="index.php?q=manageLocations">Manage locations</a>';
				echo '<li><a href="index.php?q=manageUsers">Manage users</a>';
			}
		?>
	
	</ul>
</div>
