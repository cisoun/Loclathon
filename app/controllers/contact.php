<?php
class Contact {
	private static function generate_check(&$min, &$max) {
		$min = rand(1, 5);
		$max = rand(1, 5);
		Session::set('check', strval($min + $max));
	}

	private static function message($name, $mail, $message) {
		return "$message\n\n$name\n$mail";
	}

	public static function post($params) {
		Session::start();

		// Get user data.
		$name    = Request::input('name');
		$mail    = Request::input('mail');
		$message = Request::input('message');

		// Check data and send.
		if (!Validation::email($mail)) {
			$error = 1;
		} else if (empty($message)) {
			$error = 2;
		} else if (Request::input('check') !== Session::get('check')) {
			$error = 3;
		} else {
			Mail::send([
				'host'       => env('mail_host'),
				'user'       => env('mail_user'),
				'password'   => env('mail_password'),
				'subject'    => 'Message de ' . $name,
				'body'       => self::message($name, $mail, $message),
				'from'       => env('mail_user'),
				'from_title' => env('title'),
				'to'         => [env('mail_user')],
				'bcc'        => env('agents'),
				'html'       => false,
			]);
			$sent = true;
		}

		// Regenerate verification code to avoid spam (page reloading).
		self::generate_check($min, $max);

		$params['error']   = $error ?? 0;
		$params['mail']    = $mail;
		$params['max']     = $max;
		$params['message'] = $message;
		$params['min']     = $min;
		$params['name']    = $name;
		$params['sent']    = $sent ?? false;

		Response::view('contact', $params);
	}

	public static function show($params) {
		Session::start();

		// Generate new verification field.
		self::generate_check($min, $max);

		$params['error']   = 0;
		$params['mail']    = '';
		$params['max']     = $max;
		$params['message'] = '';
		$params['min']     = $min;
		$params['name']    = '';
		$params['sent']    = false;

		Response::view('contact', $params);
	}
}
?>
