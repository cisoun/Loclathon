<?php
require_once('articles.php');

class Shop {
	private const ID_SYMBOLS       = '0123456789ABCDEF';
	private const CART             = 'cart';
	private const FORM             = 'form';
	private const ORDER            = 'order';

	public const STATE_NORMAL      = 0;
	public const STATE_PREORDER    = 1;
	public const STATE_SOLDOUT     = 2;
	public const STATE_UNAVAILABLE = 3;

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

	private static function get_prices($cart, $total, $payment, $shipping) {
		$units           = array_sum($cart);
		$shipping_fees   = self::get_shipping_fees($units, $shipping);
		$payment_fees    = self::get_payment_fees($total + $shipping_fees, $payment);
		// Round to lowest decimal.
		// 	Examples: 1.26 => 1.2, 3.98 => 3.9.
		$payment_fees    = floor($payment_fees * 10) / 10;

		return [
			'payment_fees' 	 => $payment_fees,
			'shipping_fees'  => $shipping_fees,
			'total_articles' => $total,
			'total' 		 => $total + $shipping_fees + $payment_fees
		];
	}

	private static function register_order($params) {
		// TODO: TEMPORARY WORKAROUND.
		$id = self::generate_id();
		while (Cache::has('orders', $id))
			$id = self::generate_id();
		Cache::store('orders', $id, Cache::serialize($params));
		return $id;

		// TODO: Adapt.

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
			'paypal_order_id',
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
				$statement->bindValue(':' . $key, $params[$key] ?? NULL);

			$statement->execute();
			$id = $db->lastInsertRowID();
			$db->close();
		} else {
			// Fallback.
			$id = self::generate_id();
			while (Cache::has('orders', $id))
				$id = self::generate_id();
			Cache::store('orders', $id, Cache::serialize($params));
		}

		return $id;
	}

	private static function validate(&$params, &$results) {
		$rules = [
    		'first_name' => 'stripped',
			'last_name'  => 'stripped',
			'street'     => 'stripped',
			'city'       => 'stripped',
			'npa'        => 'stripped',
			'country'    => 'stripped',
			'email'      => 'email',
			'phone'      => 'optional|stripped',
			'age'        => 'value:on',
			'payment'    => 'text',
			'shipping'   => 'text',
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

			if (array_key_exists('email', $errors))    { $results[] = 1; }
			if (array_key_exists('age', $errors))      { $results[] = 3; }
			if (array_key_exists('units', $errors))    { $results[] = 4; }
			if (array_key_exists('shipping', $errors)) { $results[] = 5; }
		}

		return $success;
	}


	public static function cart($params) {
		$inputs = Request::inputs();
		foreach ($inputs as $key => $value) {
			switch ($key) {
				case 'checkout':
					$cart = Request::input('cart');
					self::cart_update($cart);
					$lang = $params['lang'];
					return Response::location("/$lang/shop/checkout");
				case 'clear':
					return self::cart_clear($params);
				case 'delete':
					Session::start();
					$cart = Session::get(self::CART);
					unset($cart[$value]);
					Session::set(self::CART, $cart);
					break;
				case 'update':
					$cart = Request::input('cart');
					self::cart_update($cart);
					break;
			}
		}

		return Response::location("/{$params['lang']}/shop/cart");
	}

	public static function cart_add($params) {
		Session::start();

		$id = Request::input('variant') ?? $params['id'];

		$units = Request::input('units');
		$cart  = Session::get(self::CART) ?? [];

		if (!array_key_exists($id, $cart)) {
			$cart[$id] = 0;
		}

		$articles = Articles::all();
		$article  = Articles::find($articles, $id);
		$state = $article['state'];
		if ($state == self::STATE_SOLDOUT ||
			$state == self::STATE_UNAVAILABLE) {
			return Response::json(['error' => 'Unauthorized'], 403);
		}

		$cart[$id] += intval($units);

		Session::set(self::CART, $cart);

		return Response::location("/{$params['lang']}/shop/cart");
	}

	public static function cart_clear($params) {
		Session::start();
		Session::set(self::CART, []);

		return Response::location("/{$params['lang']}/shop");
	}

	public static function cart_show($params) {
		Session::start();

		$cart = Session::get(self::CART);
		if (!$cart) {
			return Response::location("/{$params['lang']}/shop", $params);
		}

		// TODO: REMOVE
		$articles = Articles::all();

		$params['articles'] = $articles;
		$params['cart'] = $cart;

		$total = 0;
		$data = [];

		foreach ($cart as $id => $value) {
			$article = Articles::find($articles, $id);
			$parent = Articles::parent($articles, $article);
			$data[] = [
				'id'      => $article['id'],
				'url'     => $article['url'] ?? $parent['url'],
				'title'   => $parent['title'] ?? $article['title'],
				'variant' => $parent ? $article['title'] : NULL,
				'price'   => $article['price'],
				'units'   => $value,
				'picture' => Articles::preview($article)
			];
			$total += $value * $article['price'];
		}

		$params['data'] = $data;
		$params['total'] = $total;

		return Response::view('shop/cart', $params);
	}

	private static function cart_update($cart) {
		$articles = Articles::all();

		foreach ($cart as $id => $units) {
			// Remove articles at 0 units.
			if ($units == 0) {
				unset($cart[$id]);
				continue;
			}

			// Remove articles that are unavailable.
			$article = Articles::find($articles, $id);
			$state = $article['state'];
			if ($state == self::STATE_SOLDOUT ||
				$state == self::STATE_UNAVAILABLE) {
				unset($cart[$id]);
				continue;
			}
		}

		Session::start();
		Session::set(self::CART, $cart);
	}

	public static function index($params) {
		$articles = Articles::all();

		// Filter unavailable articles.
		$params['articles'] = array_filter($articles, function ($a) {
			return !$a['parent_id'] && $a['state'] != 3;
		});

		return Response::view('shop/index', $params);
	}

	public static function show($params) {
		$articles = Articles::all();
		$article  = Articles::findByURL($articles, $params['url']);

		if ($article) {
			// TODO: Change.
			if ($article['parent_id'])
				$article = Articles::parent($articles, $article);

			$variants = Articles::variants($articles, $article);

			$params['article']  = $article;
			$params['variants'] = $variants;

			return Response::view('shop/product', $params);
		}

		return Response::location("/{$params['lang']}/shop");
	}

	/**
	 * User gives identity, shipping and payment method.
	 */
	public static function checkout($params) {
		Session::start();

		$cart = Session::get(self::CART);
		if (!$cart) {
			$lang = $params['lang'];
			return Response::location("/$lang/shop", $params);
		}


		if (Request::is_post()) {
			$form = Request::inputs();

			Session::set(self::FORM, $form);

			$success = self::validate($form, $errors);

			if ($success) {
				$lang = $params['lang'];
				return Response::location("/$lang/shop/review", $params);
			}

			$params['errors'] = $errors;
		}

		// Default values.
		$params['countries'] = ['CH'];
		$params['country']   = 'CH';
		$params['payment']   = 'direct';
		$params['shipping']  = 'post';

		// Replace form in session.
		$form = Session::get(self::FORM, []);
		$params = array_merge($params, $form);

		// Fix form.

		$payment = $params['payment'];
		$params['payment.direct'] = $payment == 'direct';
		$params['payment.twint']  = $payment == 'twint';
		$params['payment.paypal'] = $payment == 'paypal';

		$shipping = $params['shipping'];
		$params['shipping.local']  = $shipping == 'local';
		$params['shipping.pickup'] = $shipping == 'pickup';
		$params['shipping.post']   = $shipping == 'post';

		return Response::view('shop/checkout', $params);
	}

	/**
	 * Order has been confirmed.
	 */
	public static function confirm($params) {
		Session::start();

		$order = Session::get(self::ORDER);
		if (!$order) {
			return Response::location("/{$params['lang']}/shop", $params);
		}

		$params = array_merge($params, $order);

		// Confirm payment to PayPal.
		if ($order['payment'] == 'paypal') {
			$order_id = Session::get('paypal_order_id');
			$response = PayPal::capture($order_id);
			// PayPal may change the payment prices if the user pays by
			// credit card. Update the prices.
			$params['paypal_order_id'] = $order_id;
			$params['payment_fees']   += PayPal::get_taxes_amount($response);
			$params['total']           = PayPal::get_total_amount($response);
		}

		$params['order_id'] = self::register_order($params);

		// Send email.
		Mail::send([
			'host'       => env('mail_host'),
			'user'       => env('mail_user'),
			'password'   => env('mail_password'),
			'from'       => env('mail_noreply'),
			'from_title' => env('title'),
			'to'         => [$params['email']],
			'bcc'        => env('agents'),
			'html'       => true,
			'subject'    => __(['email.confirmation', 'subject'], $params),
			'body'       => Layout::render('emails/order', $params),
		]);

		// Remove the session cache when order is processed.
		// This prevents the user to send the order multiple times.
		Session::remove(self::CART);
		Session::remove(self::ORDER);

		return Response::view('shop/confirm', $params);
	}

	/**
	 * User is reviewing its order before paying.
	 */
	public static function review($params) {
		Session::start();
		$form = Session::get(self::FORM);
		$params = array_merge($form, $params);

		$cart = Session::get(self::CART);
		if (!$cart) {
			return Response::location("/{$params['lang']}/shop", $params);
		}

		$articles = Articles::all();
		$data = [];
		$total = 0;
		foreach ($cart as $id => $value) {
			$article = Articles::find($articles, $id);
			$parent = Articles::parent($articles, $article);
			$price = $value * $article['price'];
			$data[] = [
				'title'   => $parent['title'] ?? $article['title'],
				'variant' => $parent ? $article['title'] : NULL,
				'price'   => $price,
				'units'   => $value,
			];
			$total += $price;
		}

		$params['articles'] = $data;
		$params = array_merge($params, self::get_prices(
			$cart,
			$total,
			$form['payment'],
			$form['shipping']
		));

		Session::set(self::ORDER, $params);

		return Response::view('shop/review', $params);
	}

	/**
	 * User is paying its order.
	 */
	public static function pay($params) {
		Session::start();
		$params = array_merge($params, Session::get(self::ORDER));

		// Process the payment.
		switch($params['payment']) {
			case 'direct':
				return Response::location("/{$params['lang']}/shop/confirm");
			case 'paypal':
				$response  = PayPal::order($params);
				$order_id  = PayPal::get_order_id($response);
				$order_url = PayPal::get_approve_url($response);
				// Retain order ID.
				Session::set('paypal_order_id', $order_id);
				// Redirect user to order's approve link.
				return Response::location($order_url);
				break;
			// case 'twint': break;
			default:
				die('This was not supposed to happen...');
		}
	}
}
?>
