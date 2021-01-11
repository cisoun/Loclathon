<?php
class Request {
	/**
	 * Check if the URI contains the given extensions.
	 *
	 * @param string $extensions List of extensions separated by '|'.
	 *
	 * @return bool True if the given extension is found.
	 */
	public static function has_extension($extensions) {
		return preg_match('/\.(?:' . $extensions . ')$/', self::uri());
	}

	// public static function parameter($parameter, $request) {
	// 	return $request['parameters'][$parameter];
	// }

	public static function input($key, $fallback = '') {
		return $_REQUEST[$key];
	}

	/**
	 * Check if the method of the request is POST.
	 *
	 * @return bool True if the request method is POST.
	 */
	public static function is_post() {
		return self::method() === 'POST';
	}

	/**
	 * Return the request method.
	 *
	 * @return string Request method.
	 */
	public static function method() {
		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Return the request URI.
	 *
	 * @return string Request URI.
	 */
	public static function uri() {
		return $_SERVER['REQUEST_URI'];
	}
}
?>
