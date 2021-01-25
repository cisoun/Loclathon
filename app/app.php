<?php
require_once('config.php');

// Functions
function __($key, $params = []) { return Lang::get($key, $params); }
function call($callback)        { return Router::call($callback); }
function env($key, $fallback = false) {
	global $CONFIG;
	if (array_key_exists($key, $CONFIG))
		return $CONFIG[$key];
	return $fallback;
}
function extension($extensions) { return Request::has_extension($extensions); }
function method()               { return Request::method(); }
function redirect($url)         { return Router::redirect($url); }
function route($uri, $callback) { return Router::route($uri, $callback); };
function view($path)            { return Router::view($path); }
if (env('debug')) {
	function view_cached($path) { return Router::view($path); }
} else {
	function view_cached($path) { return Router::view_cached($path); }
}
function with_lang($callback) {
	// Load the locale given in the URI and continue.
	return function ($params) use ($callback) {
		$lang = $params['lang'];
		if (in_array($lang, env('locales'))) {
			Lang::load($lang);
			return $callback($params);
		}
		return redirect('/' . env('locale'))($params);
	};
}

/* Load the app classes whenever they are called.
 * Therefore, it will be not necessary to import them manually.
 */
spl_autoload_register(function ($class) {
	$classes = [
		// Core classes.
		// DO NOT EDIT!
		'Lang'       => 'lang',
		'Layout'     => 'layout',
		'Mail'       => 'mail',
		'Request'    => 'request',
		'Response'   => 'response',
		'Router'     => 'router',
		'Session'    => 'session',
		'Validation' => 'validation',

		// Controller classes.
		'Shop'       => 'controllers/shop',
		'Contact'    => 'controllers/contact',
	];
	if (!array_key_exists($class, $classes))
		die("$class class does not exist!");
    require_once('app/' . $classes[$class] . '.php');
});
?>
