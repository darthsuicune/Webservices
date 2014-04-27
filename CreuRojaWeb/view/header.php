<?php class Header {

	public function showHeader(User $user = null) {
		?>
<div id="header">
	<img id="logomenu" alt="logo menu" src="view/icons/logomenu.png">
	<?php // 	if ($user && $user->isAllowedTo(Actions::MENU)) {
		$menu = new Menu();
		$menu->showMenu($user);
// 	} ?>
</div>
<?php }
}?>