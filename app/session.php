<?php
class Session {
	private const CACHE_PATH = 'sessions';

	public static function all() {
		return $_SESSION;
	}

	public static function cache($content) {
		return Cache::set(
			self::CACHE_PATH,
			self::id(),
			Cache::serialize($content)
		);
	}

	public static function from_cache() {
		return Cache::unserialize(Cache::get(self::CACHE_PATH, self::id()));
	}

	public static function get($key) {
		return $_SESSION[$key];
	}

	public static function has($key) {
		return array_key_exists($key, $_SESSION);
	}

	public static function id() {
		return session_id();
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
