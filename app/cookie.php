<?php

class Cookie {
	function get($key)         { return $_COOKIE[$key]; }
	function set($key, $value) { return setcookie($key, $value); }
	function remove($key)      { return setcookie($key, NULL, 0); }
}

?>
