<?php
class Shop {
	public static function show($params) {
		Session::start();

		// $params['first_name'] = '';
		// $params['last_name'] = '';
		// $params['street'] = '';
		// $params['city'] = '';
		// $params['npa'] = '';
		// $params['country'] = 'CH';
		// $params['email1'] = '';
		// $params['email2'] = '';
		// $params['phone'] = '';

		$params['units'] = 1;

		$params['age'] = NULL;
		$params['payment'] = 'direct';
		$params['shipping'] = 'post';

		$params['countries'] = ['CH'];

		if (Session::has('FORM')) {
			$params = array_merge($params, Session::get('FORM'));
		}

		$params['age'] = $params['age'] == 'on' ? 'checked' : '';

		$checked = 'checked';

		$payment = $params['payment'];
		$params['payment.direct'] = $payment == 'direct' ? $checked : '';
		$params['payment.twint']  = $payment == 'twint'  ? $checked : '';
		$params['payment.paypal'] = $payment == 'paypal' ? $checked : '';

		$shipping = $params['shipping'];
		$params['shipping.local']  = $shipping == 'local'  ? $checked : '';
		$params['shipping.pickup'] = $shipping == 'pickup' ? $checked : '';
		$params['shipping.post']   = $shipping == 'post'   ? $checked : '';

		Response::view('shop/shop', $params);
	}

	public static function post($params) {
		$params = array_merge($params, Request::inputs());
		Session::start();
		$form = [];
		foreach (Request::inputs() as $key => $value) {
			$form[$key] = $value;
		}
		Session::set('FORM', $form);

		$result = self::check(10);
		if ($result == 0) {
			view('shop/confirm')($params);
		} else {
			$params['error'] = $result;
			self::show($params);
		}
	}

	private static function check($stock) {
		$inputs = [
			'first_name',
			'last_name',
			'street',
			'city',
			'npa',
			'country'
		];

		foreach ($inputs as $input) {
			if (!Validation::text(Request::input($input))) {
				return 1;
			}
		}

		$email1 = Request::input('email1');
		$email2 = Request::input('email2');
		$units  = Request::input('units');

		$authorized = array_key_exists('age', $_POST);

		if (!Validation::email($email1))                 { return 2; }
		else if ($email1 !== $email2)                    { return 3; }
		else if ($units > $stock)                        { return 4; }
		else if (!$authorized)                           { return 5; }

		return 0;
	}
}
?>
