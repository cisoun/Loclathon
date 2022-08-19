<?php
define('LANG_PATH', getcwd() . '/app/lang');
define('LANG_NAMES', require_once(LANG_PATH . '/langs.php'));

class Lang {
	private static array  $DATA    = [];
	private static string $LOCALE  = '';
	private static array  $LOCALES = [];

	/**
	 * Return a text specified by a key.
	 *
	 * @param string $key    Key of the text in the dictionary.
	 * @param array  $params Parameters to replace in the text.
	 */
	public static function get($key, $params = null) {
		$text = self::$DATA[$key];
		if ($params)
			return self::with_params($text, $params);
		return $text;
	}

	/**
	 * Return a text from a deep key.
	 *
	 * @param array $path   Path to the text in the dictionary.
	 * @param array $params Parameters to replace in the text.
	 */
	public static function get_through($path, $params = NULL) {
		$text = self::$DATA[array_shift($path)];
		foreach ($path as $key)
			$text = $text[$key];
		if ($params)
			return self::with_params($text, $params);
		return $text;
	}

	/**
	 * Load a given language.
	 */
	public static function load($lang) {
		self::$LOCALE = $lang;
		self::$DATA   = require_once(LANG_PATH . "/$lang.php");
	}

	/**
	 * Return the current locale.
	 */
	public static function locale() {
		return self::$LOCALE;
	}

	/**
	 * Return the available locales.
	 */
	public static function locales() {
		return env('locales');
	}

	/**
	 * Return the user's locale.
	 */
	public static function user() {
		return substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? env('locale'), 0, 2);
	}

	/**
	 * Replace variables in texts.
	 *
	 * SEE: https://www.php.net/manual/en/functions.user-defined.php
	 */
	private static function with_params($text, $params) {
		return preg_replace_callback(
			'/\{\{([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)\}\}/',
			function ($match) use ($params) {
			  return $params[$match[1]] ?? '';
			},
			$text
		);
	}
}
?>
