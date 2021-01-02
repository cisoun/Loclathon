<?php
const BLOCK_PATTERN = '[a-zA-Z0-9\-\_]+';

function read($path, $params = null) {
    ob_start();
    include($path);
    return ob_get_clean();
}

function render($path, $params = null) {
    $content = read($path, $params);

    # Process parent view if extends.
    if ($layout = search_extend($content)) {
		$blocks = search_blocks($content);
		$content = render(getcwd() . '/' . $layout . '.php', $params);
		$content = replace_blocks($content, $blocks);
    }

    return replace_params($content, $params);
}

function replace_blocks($content, $blocks, $fallback = '') {
	return preg_replace_callback(
		'/<\?\s?(' . BLOCK_PATTERN . ')\s?\?>/',
		function ($match) use ($blocks, $fallback) {
		  return $blocks[$match[1]] ?? $fallback;
		},
		$content
	);
}

function replace_params($content, $params) {
	return preg_replace_callback(
        '/\{\{\s*(' . BLOCK_PATTERN . ')(\s*\|\s*\"(.*)\")?\s*\}\}/',
        function ($match) use ($params) {
          return $params[$match[1]] ?? $match[3];
        },
        $content
    );
}

function search_extend($content) {
	if (preg_match('/^<extend>(.*)?(?=<\/extend>)/im', $content, $matches))
		return $matches[1];
	return false;
}

function search_blocks($content) {
	$blocks = [];
	$matches = preg_match_all(
		'/<block ([a-zA-Z0-9\-\_]+)>\s*(.+?)\s*<\/block>/ims',
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
?>
