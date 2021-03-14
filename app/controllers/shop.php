<?php
class Shop {
	public const BOTTLE_PRICE = 38;
	private const ID_SYMBOLS = '0123456789ABCDEF';

	private static function generate_id() {
		$id = '';
		for ($i = 0; $i < 6; $i++)
			$id .= self::ID_SYMBOLS[rand(0, 15)];
		return $id;
	}

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
		$params['email'] = $params['email1'];
		unset($params['email1']);
		unset($params['email2']);

		// Cache the data so the user cannot modify them before confirmation.
		// Cached data will be reused at confirmation.
		Session::cache($params);

		return Response::view('shop/checkout', $params);
	}

	private static function register_order($params) {
		$keys = [
			'first_name',
			'last_name',
			'street',
			'city',
			'npa',
			'country',
			'email',
			'phone',
			'units',
			'payment',
			'shipping',
			'price',
			'payment_fees',
			'shipping_fees',
			'total'
		];

		// Write to database or in cache.
		if (file_exists('database.db')) {
			$db = new SQLite3('database.db');

			// Prepare SQL query.
			$query = 'INSERT INTO orders ( %s ) VALUES ( %s )';
		    $query_keys = implode(',', $keys);
		    $query_values = ':' . implode(',:', $keys);
		    $query = sprintf($query, $query_keys, $query_values);

			// Bind values.
			$statement = $db->prepare($query);
			foreach ($keys as $key)
        		$statement->bindValue(':' . $key, $params[$key]);

			$statement->execute();
			$id = $db->lastInsertRowID();
			$db->close();
		} else {
			// Fallback.
			$id = self::generate_id();
			while (Cache::has('orders', $id))
				$id = self::generate_id();
			Cache::set('orders', $id, Cache::serialize($params));
		}

		return $id;
	}

	public static function show_confirm($params) {
		Session::start();
		$data = Session::from_cache();

		// Redirect user to shop if session cache is removed
		// (order already processed).
		if (!$data) {
			return Response::location('/' . $params['lang'] . '/shop');
		}

		$params = array_merge($params, $data);
		$params['order_id'] = self::register_order($params);

		// Process the payment.
		switch($params['payment']) {
			case 'direct': break; // Nothing to do.
			case 'paypal':
				die('todo');
				break;
			case 'twint':
				die('todo');
				break;
			default:
				die('Mmh what...');
		}

		// Send email
		$email['host']       = env('mail_host');
		$email['user']       = env('mail_user');
		$email['password']   = env('mail_password');
		$email['from']       = 'noreply@loclathon.ch';
		$email['from_title'] = 'Le Loclathon';
		$email['to']         = env('agents');
		$email['html']       = true;
		$email['subject']    = __('email.confirmation')['subject'] . $params['order_id'];
		$email['body']       = Layout::render('emails/confirmation', $params);
		Mail::send($email);

		// Remove the session cache when order is processed.
		// This prevents the user to send the order multiple times.
		Session::remove_cache();

		return Response::view('shop/confirm', $params);
	}

	public static function show_shop($params) {
		// Default values.
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

	public static function validate(&$params, &$results) {
		$rules = [
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
		];
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
