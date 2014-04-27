<?php
if(file_exists("config.php")){
	header("Location: index.php");
} else {
	if(isset($_POST[])) {
		
	}
	doInstall();
}

function doInstall() {
	
}