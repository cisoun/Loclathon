<?php
define('VIEWS_PATH', getcwd() . '/app/views');

class Layout {
	private const BLOCK_PATTERN = '[a-zA-Z0-9\-\_\.]+';

	public static function read($path, $params = null) {
		ob_start();
		include($path);
		return ob_get_clean();
	}

	public static function render($view, $params = null) {
		$content = self::read(VIEWS_PATH . "/$view.php", $params);

		# Process parent view if extends.
		if ($layout = self::search_extend($content)) {
			$blocks = self::search_blocks($content);
			$content = self::render($layout, $params);
			$content = self::replace_blocks($content, $blocks);
		}

		return self::replace_params($content, $params);
	}

	private static function replace_blocks($content, $blocks, $fallback = '') {
		return preg_replace_callback(
			'/<\?\s?(' . self::BLOCK_PATTERN . ')\s?\?>/',
			function ($match) use ($blocks, $fallback) {
				return $blocks[$match[1]] ?? $fallback;
			},
			$content
		);
	}

	private static function replace_params($content, $params) {
		return preg_replace_callback(
			'/\{\{\s*(' . self::BLOCK_PATTERN . ')(\s*\|\s*\"(.*)\")?\s*\}\}/',
			function ($match) use ($params) {
				return $params[$match[1]] ?? $match[3] ?? '';
			},
			$content
		);
	}

	private static function search_extend($content) {
		if (preg_match('/^<extend>(.*)?(?=<\/extend>)/im', $content, $matches))
			return $matches[1];
		return false;
	}

	private static function search_blocks($content) {
		$blocks = [];
		$matches = preg_match_all(
			'/<block ([a-zA-Z0-9\-\_]+)>\s*(.*?)\s*<\/block>/ims',
			$content,
			$results,
			PREG_SET_ORDER
		);
		if ($matches) {
			foreach ($results as $result) {
				$blocks[$result[1]] = $result[2];
			}
		}
		return $blocks;
	}
}
?>
