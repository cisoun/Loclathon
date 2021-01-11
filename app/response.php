<?php
class Response {
	public static function view($view, $params) {
		echo Layout::render($view, $params);
	}

	public static function view_cached($view, $params) {
		$file = getcwd() . '/cache/' . str_replace('/', '_', Request::uri());
		if (file_exists($file)) {
			echo file_get_contents($file);
		} else {
			$content = Layout::render($view, $params);
			file_put_contents($file, $content);
			echo $content;
		}
	}
}
?>
