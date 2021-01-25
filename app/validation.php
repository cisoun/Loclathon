<?php
class Validation {
	public static function email($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	public static function text($var) {
		return trim($var) != false;
	}
}
?>
