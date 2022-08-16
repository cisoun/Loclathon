<?php
class Response {
	public static function json($data, $code = 200) {
		header('Content-Type: application/json; charset=utf-8');
		http_response_code($code);
		echo json_encode($data);
	}

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
			Cache::store($folder, $file, $content);
			echo $content;
		}
	}
}
?>
