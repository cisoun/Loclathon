<?php
define('CACHE_PATH', getcwd() . '/cache');

class Cache {
	public static function flush($folder) {
		$path = CACHE_PATH . '/' . $folder . '/*';
		array_map('unlink', glob($path));
	}

	public static function get($folder, $name) {
		$file = CACHE_PATH . '/' . $folder . '/' . $name;
		if (file_exists($file))
			return file_get_contents($file);
		return false;
	}

	public static function has($folder, $name) {
		return file_exists($folder . '/' . $name);
	}

	public static function remove($folder, $name) {
		return unlink(CACHE_PATH . '/' . $folder . '/' . $name);
	}

	public static function serialize($content) {
		return serialize($content);
	}

	public static function set($folder, $name, $content) {
		$file = CACHE_PATH . '/' . $folder . '/' . $name;
		return file_put_contents($file, $content);
	}

	public static function unserialize($content) {
		return unserialize($content);
	}
}
?>
