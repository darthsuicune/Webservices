<?php class Header {

	public function showHeader(User $user = null) {
		?>
<div id="header">
	<?php // 	if ($user && $user->isAllowedTo(Actions::MENU)) {
		$menu = new Menu();
		$menu->showMenu($user);
// 	} ?>
</div>
<?php }
}?>