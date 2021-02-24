<?php
class Validation {
	/**
	 * Validate and sanitize an array according to given rules.
	 *
	 * Rules can be chained with a vertical bar.
	 *
	 * Rules:
	 * 	- email:           Must be an email address.
	 * 	- html:            Must be a string.
	 *	- int:             Must be a number.
	 *  - range:min:max:   Must be a number between `min` and `max`.
	 * 	- same:field1:...: Must be the same as the given fields.
	 * 	- string:          Must be a string WITHOUT HTML chars.
	 * 	- text:            Must NOT be an empty string.
	 * 	- value:val1:...:  Must be one of the given values.
	 *
	 * Example:
	 *	Validation::array($array, array(
	 *		'name'   => 'text',
	 *		'age'    => 'int|range:1:100',
	 *		'gender' => 'value:man:woman',
	 *		'email1' => 'email',
	 *		'email2' => 'email|same:email1',
	 *	), $errors);
	 *
	 * @param array $array  Array to validate.
	 * @param array $field  Array containing rules (field => rules).
	 * @param array $errors Found errors.
	 *
	 * @return bool Array is valid or not.
	 */
	public static function array(&$array, $fields, &$errors) {
		$errors = [];
		foreach ($fields as $field => $rules) {
			$callbacks = explode('|', $rules);
			foreach ($callbacks as $callback) {
				$error    = NULL;
				$args     = explode(':', $callback);
				$callback = array_shift($args);
				$array[$field] = self::array_check($callback, $args, $array, $field, $error);
				if ($error) {
					$errors[$field][$callback] = $error;
				}
			}
		}
		return count($errors) == 0;
	}

	/**
	 * Subfunction for Validation::array.
	 *
	 * Validate and sanitize a field from an array according to its rules.
	 * An error is returned with the expected values if raised.
	 *
	 * @param string $rule Rule of the field.
	 * @param array $args  Arguments of the rule (separated by ':').
	 * @param array $array Array to validate and sanitize.
	 * @param bool $error  Returned error for the given field.
	 *
	 * @return bool Array is valid or not.
	 */
	private static function array_check($rule, $args, $array, $field, &$error) {
		$value = $array[$field] ?? NULL;
		switch ($rule) {
			// case 'default':
			// 	return $value ? $value : $args;
			case 'email':
				$error = !self::email($value);
				return filter_var($value, FILTER_SANITIZE_EMAIL);
			case 'html':
				return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
			case 'int':
				return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
			case 'range':
				$error = !self::range($value, ...$args) ? $args : false;
				return $value; // Sanitized by self::range().
			case 'same':
				foreach ($args as $arg) {
					if ($value !== $array[$arg]) {
						$errors[] = $arg;
					}
				}
				$error = $errors ?? false;
				return $value;
			case 'string':
				return filter_var($value, FILTER_SANITIZE_STRING);
			case 'text':
				$error = !self::text($value);
				return filter_var($value, FILTER_SANITIZE_STRING);
			case 'value':
				$error = !in_array($value, $args);
				return $value;
			default:
				return $value;
		}
	}

	/**
	 * Check if a variable contains an email address.
	 *
	 * @return bool
	 */
	public static function email($email) {
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

	public static function range($range, $min, $max) {
		if ($range = filter_var($range, FILTER_VALIDATE_INT)) {
			return $range >= $min && $range <= $max;
		}
		return false;
	}

	public static function sanitized_email($email) {
		return filter_var($email, FILTER_SANITIZE_EMAIL);
	}

	/**
	 * Check if a variable contains a text and not only spaces.
	 *
	 * @return bool
	 */
	public static function text($var) {
		return trim($var) != false;
	}
}
?>
