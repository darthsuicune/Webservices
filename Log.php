<?php
class Log {
	
	public static function write(User $user = null, $action, $version = "web") {
		$data = "";
		if($user) {
			$data = "User { $user->name $user->surname, $user->email } has requested [ $action ] from $version version";
		} else {
			$data = "Requested action [ $action ] from $version version";
		}
		Log::writeToFile($data);
	}
	
	public static function failWrite(User $user = null, $action, $version = "web") {
		$data = "Failed action [ $action ] in $version version";
		if($user) {
			$data .= " by user { $user->name $user->surname, $user->email }";
		}
		Log::writeToFile($data);
	}
	
	static function writeToFile($data) {
		$time = date("Y-m-d H:i:s");
		file_put_contents(LOG_FILE, $data . " at $time\n", FILE_APPEND);
	}
}