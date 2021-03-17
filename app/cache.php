<?php
define('CACHE_PATH', getcwd() . '/cache');

/**
 * Cache class.
 *
 * This class helps to store temporary data into the `cache` folder.
 * The cached content is usually put into a dedicated subfolder. For instance,
 * a prerendered HTML view will be put into the `views` subfolder.
 *
 * WARNING: Do not put content that must not be lost.
 * TIP:     On a *NIX system, mount this folder as `tmpfs`.
 */
class Cache {
	/**
	 * Remove all cached content from a folder.
	 *
	 * @param string $folder Name of the folder to clear.
	 */
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

	public static function store($folder, $name, $content) {
		$file = CACHE_PATH . '/' . $folder . '/' . $name;
		return file_put_contents($file, $content);
	}

	public static function unserialize($content) {
		return unserialize($content);
	}
}
?>
