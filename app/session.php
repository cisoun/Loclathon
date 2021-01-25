<?php
class Session {
	public static function all() {
		return $_SESSION;
	}

	public static function get($key) {
		return $_SESSION[$key];
	}

	public static function has($key) {
		return array_key_exists($key, $_SESSION);
	}

	public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	public static function start() {
		if (session_status() == PHP_SESSION_NONE) {
		  session_start();
		}
	}
}
?>
