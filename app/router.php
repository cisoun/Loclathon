<?php
class Router {
	/**
	* Do something when a route is valid.
	*
	* @param string $uri      URI of the route.
	* @param array  $callback Callback to call.
	*                         Must provide an associative array as parameter.
	*
	* @return null
	*/
	public static function route($uri, $callback) {
		// Transform route into a regex pattern.
		$pattern = preg_replace('/:[^\/]+/', '([^/]+)', $uri);
		$pattern = preg_replace('/\//', '\\/', $pattern);
		$pattern = "/^$pattern\/?$/";

		// Check if URI matches route pattern.
		if (preg_match_all($pattern, Request::uri(), $matches, PREG_SET_ORDER)) {
			if (preg_match_all('/:([^\/]+)/', $uri, $fields)) {
				$callback(array_combine($fields[1], array_slice($matches[0], 1)));
			} else {
				$callback([]);
			}
			die(); // Don't process other routes.
		}
	}

	public static function redirect($url) {
		return function ($params) use ($url) {
			header('Location: ' . $url);
		};
	}

	public static function view($view) {
		return function ($params) use ($view) {
			echo Layout::render($view, $params);
		};
	}

	public static function view_cached($view) {
		return function ($params) use ($view) {
			$file = getcwd() . '/cache/' . str_replace('/', '_', Request::uri());
			if (file_exists($file)) {
				echo file_get_contents($file);
			} else {
				$content = Layout::render($view, $params);
				file_put_contents($file, $content);
				echo $content;
			}
		};
	}
}
?>
