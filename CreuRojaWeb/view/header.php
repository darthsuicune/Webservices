<?php class Header {

	public function showHeader(User $user = null) {
		?>
<div id="header">
	<a href="index.php" ><img id="logomenu" alt="logo menu" src="view/icons/logomenu.png"></a>
	<?php // 	if ($user && $user->isAllowedTo(Actions::MENU)) {
		$menu = new Menu();
		$menu->showMenu($user);
// 	} ?>
</div>
<?php }
}?>