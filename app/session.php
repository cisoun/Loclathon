<?php
/**
 * Session class.
 *
 *   The sessions are stored in separated files in the server in the folder
 *   defined by `session.save_path` in `php.ini` (by default `/tmp`).
 *
 *   A good practice is to ensure the sessions path points to a tmpfs
 *   mounted directory, which is uually the case.
 */

// Comment the following line to store sessions in the default directory.
// session_save_path(getcwd() . '/cache/sessions');

class Session {
	public static function all() {
		return $_SESSION;
	}

	public static function destroy() {
		return session_destroy();
	}

	public static function get($key, $fallback = NULL) {
		return $_SESSION[$key] ?? $fallback;
	}

	public static function has($key) {
		return array_key_exists($key, $_SESSION);
	}

	public static function id() {
		return session_id();
	}

	public static function merge($array) {
		$_SESSION = array_merge($_SESSION, $array);
	}

	public static function remove($key) {
		unset($_SESSION[$key]);
	}

	public static function replace($array) {
		$_SESSION = $array;
	}

	public static function reset() {
		return session_reset();
	}

	public static function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	public static function start() {
		if (session_status() == PHP_SESSION_NONE)
		 	session_start();
	}
}
?>
