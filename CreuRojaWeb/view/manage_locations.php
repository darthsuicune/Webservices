<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<HTML>
	<?php
		if (isset($_SESSION['user'])) {
			$user = $_SESSION['user'];
		}
		require_once('header.php');
		$user = false;
	?>
	<BODY>
		<?php
			if ($user && $user->isAllowedTo(Actions::SIDEBAR)) {
				require_once('sidebar.php');
			}
		?>
		<div class="content">
		</div>
		<?php 
			require_once('footer.php');
		?>
	</BODY>
</HTML>