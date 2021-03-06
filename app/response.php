<?php
class Response {
	public static function location($url) {
		header('Location: ' . $url);
	}

	public static function view($view, $params) {
		echo Layout::render($view, $params);
	}

	public static function view_cached($view, $params) {
		$folder = 'views';
		$file = str_replace('/', '_', Request::uri());
		if (Cache::has($folder, $file)) {
			echo Cache::get($folder, $file);
		} else {
			$content = Layout::render($view, $params);
			Cache::set($folder, $file, $content);
			echo $content;
		}
	}
}
?>
