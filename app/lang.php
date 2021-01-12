<?php
class Lang {
	private static string $PATH = 'lang';
	private static array  $DATA = [];

	public static function langs() {
		return glob(self::$PATH . '/*.php');
	}

	public static function load($lang) {
		self::$DATA = require_once(self::$PATH . '/' . $lang . '.php');
	}

	public static function get($key, $params = null) {
		$text = self::$DATA[$key];
		if ($params) {
			foreach ($params as $param => $value) {
				$text = preg_replace('\{\{\s*' . $param . '\s*\}\}', $value, $text);
			}
		}
		return $text;
	}

	public static function user() {
		return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	}
}
?>
