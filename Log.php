<?php
class Log {
	const LOG_FILE = "/tmp/CRwebservice.log";
	
	public static function write(User $user = null, $action) {
		$data = "";
		if($user) {
			$data = "User { $user->name $user->surname, $user->email } has requested [ $action ]";
		} else {
			$data = "Requested action [ $action ]";
		}
		Log::writeToFile($data);
	}
	
	public static function failWrite(User $user = null, $action) {
		$data = "Failed action [ $action ]";
		if($user) {
			$data .= " by user { $user->name $user->surname, $user->email }";
		}
		Log::writeToFile($data);
	}
	
	static function writeToFile($data) {
		$time = date("Y-m-d H:i:s");
		file_put_contents(self::LOG_FILE, $data . " at $time\n", FILE_APPEND);
	}
}