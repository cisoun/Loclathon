<?php

/**
 *
 */
class HTML {

	private static function buildAttributes($attrs) {
		$attributes = '';
		foreach ($attrs as $key => $value) {
			$attributes .= " $key=\"$value\"";
		}
		return $attributes;
	}

	public static function input($name, $value, $attrs) {
		// TODO
	}

	public static function option($value, $attrs = []) {
		$a = self::buildAttributes($attrs);
		return "<option$a>$value</option>";
	}

}


?>
