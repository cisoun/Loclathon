<?php
function read($path, $params=null) {
    ob_start();
    include($path);
    return ob_get_clean();
}

function parse_matches(&$array, $key, $value) {
	$data = [];
	foreach ($array as $item) {
		$data[$item[$key]] = $item[$value];
	}
	return $data;
}

function render($path, $params=null) {
    # Get page content.
    $content = read($path, $params);
    $layout_content = $content;

    # Process parent view if extends.
    if (preg_match('/^\@extend\(\'([^\']+)\'\);?/mi', $content, $matches)) {
        $layout = $matches[1];
        $layout_content = render(getcwd() . '/' . $layout . '.php', $params);

        # Replace data.
        $pattern = '/^\@data\(\'([^\']+)\',\s+\'([^\)]+)\'\)/';
        preg_match_all($pattern, $content, $data, PREG_SET_ORDER);
		$data = parse_matches($data, 1, 2);
        $layout_content = preg_replace_callback(
            '/\@data\(\'([a-zA-Z0-9\-_]+)\'\);?/',
            function ($match) use ($data) {
              return $data[$match[1]] ?? $match[3] ?? '';
            },
            $layout_content
        );

        # Replace sections.
        $pattern = '/(?<=\@section)\(\'([^\']+)\'\)(.*?)(?=\@endsection)/ism';
        preg_match_all($pattern, $content, $sections, PREG_SET_ORDER);
		$sections = parse_matches($sections, 1, 2);
        $layout_content = preg_replace_callback(
            '/\@render\(\'([a-zA-Z0-9\-_]+)\'\);?/',
            function ($match) use ($sections) {
              return $sections[$match[1]] ?? '';
            },
            $layout_content
        );
    }

    $layout_content = preg_replace_callback(
        '/\{\{\s*([a-zA-Z0-9\-_]+)(\s*\|\s*\"(.*)\")?\s*\}\}/',
        function ($match) use ($params) {
          return $params[$match[1]] ?? $match[3];
        },
        $layout_content
    );

    return $layout_content;
}
?>
