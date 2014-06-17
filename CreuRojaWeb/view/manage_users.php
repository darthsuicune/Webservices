<?php class UserManager implements Content {
	public function showContent(Notice $notices = null) {
		?>
<div id="user_manager">
</div>
<?php 
require_once('footer.php');
	}

	public function getHtmlHeaders() { ?>
<link href="view/css/usermanager.css" rel="stylesheet" type="text/css" />
<link href="view/css/notice.css" rel="stylesheet" type="text/css" />
<?php 
	}
}?>