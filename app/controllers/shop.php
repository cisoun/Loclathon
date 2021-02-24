<?php
class Shop {
	private static function prices() {

	}
	
	public static function show($params) {
		// $params['first_name'] = '';
		// $params['last_name'] = '';
		// $params['street'] = '';
		// $params['city'] = '';
		// $params['npa'] = '';
		// $params['country'] = 'CH';
		// $params['email1'] = '';
		// $params['email2'] = '';
		// $params['phone'] = '';

		// Values by default.
		// $params['age'] = NULL;
		$params['countries'] = ['CH'];
		$params['email'] = '';
		$params['payment'] = 'direct';
		$params['shipping'] = 'post';
		$params['units'] = 1;

		// Restore form if available.
		Session::start();
		if (Session::has('FORM')) {
			$params = array_merge($params, Session::get('FORM'));
		}

		// Fix form.

		$checked = 'checked';

		$payment = $params['payment'];
		$params['payment.direct'] = $payment == 'direct' ? $checked : '';
		$params['payment.twint']  = $payment == 'twint'  ? $checked : '';
		$params['payment.paypal'] = $payment == 'paypal' ? $checked : '';

		$shipping = $params['shipping'];
		$params['shipping.local']  = $shipping == 'local'  ? $checked : '';
		$params['shipping.pickup'] = $shipping == 'pickup' ? $checked : '';
		$params['shipping.post']   = $shipping == 'post'   ? $checked : '';

		return Response::view('shop/shop', $params);
	}

	public static function show_confirm($params) {
		$units = $params['units'] * 38;
		$payment = 3;
		$shipping = 9.7;

		$params['units_price'] 	  = $units;
		$params['payment_price']  = $payment;
		$params['shipping_price'] = $shipping;
		$params['total_price'] 	  = $units + $payment + $shipping;

		Response::view('shop/confirm', $params);
	}

	public static function post($params) {
		$inputs = Request::inputs();
		$success = self::validate($inputs, $errors);
		$params = array_merge($params, $inputs);

		Session::start();
		Session::set('FORM', $params);

		// var_dump($inputs);
		// var_dump($errors);
		// die();

		$params['stock'] = 10;

		if (!$success) {
			$params['errors'] = $errors;
			return self::show($params);
		}

		return self::show_confirm($params);
	}

	public static function validate(&$params, &$results) {
		$rules = array(
    		'first_name' => 'text',
			'last_name'  => 'text',
			'street'     => 'text',
			'city'       => 'text',
			'npa'        => 'text',
			'country'    => 'text',
			'email1'     => 'email',
			'email2'     => 'email|same:email1',
			'phone'      => 'text',
			'age'        => 'value:on',
			'payment'    => 'text',
			'shipping'   => 'text',
			'units'      => 'range:1:3' // TODO: Add stock.
		);
		$mandatory_fields = [
			'first_name',
			'last_name',
			'street',
			'city',
			'npa',
			'country'
		];

		$success = Validation::array($params, $rules, $errors);

		if (!$success) {
			foreach ($mandatory_fields as $field) {
				if (array_key_exists($field, $errors)) {
					$results[] = 0;
					break;
				}
			}

			if (array_key_exists('email1', $errors)) { $results[] = 1; }
			if (array_key_exists('email2', $errors)) { $results[] = 2; }
			if (array_key_exists('age', $errors))    { $results[] = 3; }
			if (array_key_exists('units', $errors))  { $results[] = 4; }
		}

		return $success;
	}
}
?>
