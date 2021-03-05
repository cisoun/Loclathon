<?php
class Shop {
	public const BOTTLE_PRICE = 38;

	private static function get_payment_fees($price, $payment) {
		switch ($payment) {
			# SEE: https://www.paypal.com/businesswallet/classic-fees
			case 'paypal': return 0.55 + $price * 0.034;
			# SEE: https://www.twint.ch/content/uploads/2017/03/Payment-Vertrag-Portal-FR.pdf
			case 'twint':  return $price * 0.013;
			default:       return 0;
		}
	}

	private static function get_shipping_fees($units, $shipping) {
		switch ($shipping) {
			# Swiss Post: price calculated after the weight of the cardboard
			#	and bottle. After 4 bottles, ceil to 15 CHF.
			# TODO: test and adapt later!
			# SEE: https://www.post.ch/fr/expedier-des-colis
			case 'post': return [10, 12.5, 13.5, 15][min($units - 1, 3)];
			default:     return 0;
		}
	}

	private static function get_prices($units, $payment, $shipping) {
		$price           = $units * self::BOTTLE_PRICE;
		$shipping_fees   = self::get_shipping_fees($units, $shipping);
		$payment_fees    = self::get_payment_fees($price + $shipping_fees, $payment);
		// Round to lowest decimal.
		// 	Examples: 1.26 => 1.2, 3.98 => 3.9.
		$payment_fees    = floor($payment_fees * 10) / 10;

		return [
			'price' 		=> $price,
			'payment_fees' 	=> $payment_fees,
			'shipping_fees' => $shipping_fees,
			'total' 		=> $price + $shipping_fees + $payment_fees
		];
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
		Session::set('FORM', $inputs);

		$params['stock'] = 10;

		if (!$success) {
			$params['errors'] = $errors;
			return self::show($params);
		}

		// Calculate prices and fees.
		$prices = self::get_prices(
			$params['units'],
			$params['payment'],
			$params['shipping']
		);
		$params = array_merge($params, $prices);

		// Cache the data so the user cannot modify them before confirmation.
		// Cached data will be reused at confirmation.
		Session::cache($params);

		return self::show_confirm($params);
	}

	public static function validate(&$params, &$results) {
		$rules = array(
    		'first_name' => 'stripped',
			'last_name'  => 'stripped',
			'street'     => 'stripped',
			'city'       => 'stripped',
			'npa'        => 'stripped',
			'country'    => 'stripped',
			'email1'     => 'email',
			'email2'     => 'email|same:email1',
			'phone'      => 'optional|stripped',
			'age'        => 'value:on',
			'payment'    => 'text',
			'shipping'   => 'text',
			'units'      => 'range:1:6' // TODO: Add stock.
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

		// Check shipping if local.
		if ($params['shipping'] == 'local' and
			!in_array($params['npa'], [2300, 2400])) {
			$success = false;
			$errors['shipping'] = true;
		}

		if (!$success) {
			foreach ($mandatory_fields as $field) {
				if (array_key_exists($field, $errors)) {
					$results[] = 0;
					break;
				}
			}

			if (array_key_exists('email1', $errors))   { $results[] = 1; }
			if (array_key_exists('email2', $errors))   { $results[] = 2; }
			if (array_key_exists('age', $errors))      { $results[] = 3; }
			if (array_key_exists('units', $errors))    { $results[] = 4; }
			if (array_key_exists('shipping', $errors)) { $results[] = 5; }
		}

		return $success;
	}
}
?>
