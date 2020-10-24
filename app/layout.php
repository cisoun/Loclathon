<?php
function read($path, $params=null) {
    ob_start();
    include($path);
    return ob_get_clean();
}

function render($path, $params=null) {
    # Get page content.
    $content = read($path, $params);
    $layout_content = $content;

    $layout_content = preg_replace_callback('
        /\{\{\s*([a-zA-Z0-9\-_]+)\s*\}\}/',
        function ($match) use ($params) {
          return $params[$match[1]] ?? ''; //(as fallback)
        },
        $content
    );

    # Get layout.
    if (preg_match('/\@extend\(\'([^\']+)\'\);?/', $content, $matches)) {
      $layout = $matches[1];
      $layout_content = render(getcwd() . '/' . $layout . '.php', $params);
    } else {
      return $layout_content;
    }

    # Get data.
    preg_match_all(
        '/(\@data\(\'([^\']+)\',\s+\'([^\)]+)\'\))/',
        $content,
        $data,
        PREG_SET_ORDER
    );

    # Get sections.
    preg_match_all(
        '/((?<=\@section)\(\'([^\']+)\'\)(.*?)(?=\@endsection))/ism',
        $content,
        $sections,
        PREG_SET_ORDER
    );

    # Rewrite layout with content.
    foreach ($sections as $section) {
        $name = $section[2];
        $content = $section[3];
        $layout_content = preg_replace('
            /\@render\(\'' . $name . '\'\);?/',
            $content,
            $layout_content
        );
    }

    foreach ($data as $datum) {
        $key = $datum[2];
        $value = $datum[3];
        $layout_content = preg_replace('
            /\@data\(\'' . $key . '\'\);?/',
            $value,
            $layout_content
        );
    }

    $layout_content = preg_replace_callback('
        /{\{\s*([a-zA-Z0-9\-_]+)(\s*\|\s*\"(.*)\")?\s*\}\}/',
        function ($match) use ($params) {
          return $params[$match[1]] ?? $match[3];
        },
        $layout_content
    );

    return $layout_content;
}
?>
