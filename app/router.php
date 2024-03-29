<?php
class Router {
	public static function call($callback) {
		return function ($params) use ($callback) {
			return call_user_func($callback, $params);
		};
	}

	// public static function prefix($prefix, $callback) {
	// 	$uri = Request::uri();
	// 	if (str_starts_with($uri, $prefix)) {
	// 		return $callback($uri);
	// 	}
	// }

	/**
	* Do something when a route is valid.
	*
	* @param string $path     Path of the route.
	* @param array  $callback Callback to call.
	*                         Must provide an associative array as parameter.
	*
	* @return null
	*/
	public static function route($path, $callback) {
		// Transform route into a regex pattern.
		$pattern = preg_replace('/:[^\/]+/', '([^/]+)', $path); // Capture route parameters.
		$pattern = preg_replace('/\//', '\\/', $pattern);       // Escape slashes.

		// Check if URI matches route pattern.
		if (preg_match("/^$pattern\/?$/", Request::path(), $matches)) {
			// Extract route parameters if any and pass them to callback.
			if (preg_match_all("/(?<=:)[^\/]+/", $path, $fields)) {
				$callback(array_combine($fields[0], array_slice($matches, 1)));
			} else {
				$callback([]);
			}
			die(); // Don't process other routes.
		}
	}

	public static function redirect($url) {
		return function ($params) use ($url) {
			Response::location($url);
		};
	}

	public static function view($view) {
		return function ($params) use ($view) {
			Response::view($view, $params);
		};
	}

	public static function view_cached($view) {
		return function ($params) use ($view) {
			Response::view_cached($view, $params);
		};
	}
}
?>
