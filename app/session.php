<?php
class Session {
	private const CACHE_PATH = 'sessions';

	public static function all() {
		return $_SESSION;
	}

	public static function cache($data) {
		return Cache::set(
			self::CACHE_PATH,
			self::id(),
			Cache::serialize($data)
		);
	}

	public static function from_cache() {
		$data = Cache::get(self::CACHE_PATH, self::id());
		if ($data)
			return Cache::unserialize($data);
		return false;
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

	public static function remove_cache() {
		return Cache::remove(self::	CACHE_PATH, self::id());
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
