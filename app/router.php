<?php
$uri = $_SERVER['REQUEST_URI'];

function extension($extensions) {
  global $uri;
  return preg_match('/\.(?:' . $extensions . ')$/', $uri);
}

function method() {
  return $_SERVER['REQUEST_METHOD'];
}

function route($route, $callback) {
  global $uri;

  // Transform route into a regex pattern.
  $pattern = preg_replace('/:[^\/]+/', '([^/]+)', $route);
  $pattern = preg_replace('/\//', '\\/', $pattern);
  $pattern = "/^$pattern\/?$/";

  // Check if URI matches route pattern.
  if (preg_match_all($pattern, $uri, $matches, PREG_SET_ORDER)) {
    if (preg_match_all('/:([^\/]+)/', $route, $fields)) {
      $callback(array_combine($fields[1], array_slice($matches[0], 1)));
    } else {
      $callback([]);
    }
    die(); // Don't process other routes.
  }
}

function redirect($url) {
  return function ($params) use ($url) {
    header('Location: ' . $url);
  };
}

function cached_view($path) {
  return view($path);
  return function ($params) use ($path) {
    global $uri;
    $file = getcwd() . '/cache/' . str_replace('/', '_', $uri);
    if (file_exists($file)) {
      echo file_get_contents($file);
    } else {
      require_once('layout.php');
      $content = render(getcwd() . '/views/' . $path . '.php', $params);
      file_put_contents($file, $content);
      echo $content;
    }
  };
}

function view($path) {
  return function ($params) use ($path) {
    require_once('layout.php');
    echo render(getcwd() . '/views/' . $path . '.php', $params);
  };
}
?>
