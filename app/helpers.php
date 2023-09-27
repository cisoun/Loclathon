<?php

class Helpers {
	public static function path_join(...$segments) {
	    return join(DIRECTORY_SEPARATOR, $segments);
	}
}

?>