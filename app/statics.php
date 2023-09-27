<?php
define('STATIC_PATH', '/static');

class Statics {
	public static function images($path = '') {
		return Helpers::path_join(STATIC_PATH, 'img', $path);
	}
}
?>
