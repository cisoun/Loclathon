<?php
define('STATICS_PATH', '/statics');

class Statics {
	public static function css($path) {
		return Helpers::path_join(STATICS_PATH, 'css', $path);
	}

	public static function images($path = '') {
		return Helpers::path_join(STATICS_PATH, 'img', $path);
	}

	public static function get($path) {
		return Helpers::path_join(STATICS_PATH, $path);
	}
}
?>
