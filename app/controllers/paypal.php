<?php
/**
 * PayPal controller.
 *
 * Merchant dashboard: https://developer.paypal.com/developer/accounts/
 * Sandbox dashboard:  https://www.sandbox.paypal.com/mep/dashboard
 *
 * Documentation:
 *	- https://github.com/paypal/Checkout-PHP-SDK
 *	- https://developer.paypal.com/docs/checkout/reference/server-integration/setup-sdk/
 */
require_once('vendor/autoload.php');

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class PayPal
{
    /**
     * Returns PayPal HTTP client instance with environment that has access
     * credentials context. Use this instance to invoke PayPal APIs, provided the
     * credentials have access.
     */
    public static function client() {
        return new PayPalHttpClient(self::environment());
    }

    /**
     * Set up and return PayPal PHP SDK environment with PayPal access credentials.
     * This sample uses SandboxEnvironment. In production, use LiveEnvironment.
     */
    public static function environment()
    {
        $clientId = env('paypal_id');
        $clientSecret = env('paypal_secret');
		if (env('debug'))
			return new SandboxEnvironment($clientId, $clientSecret);
        return new LiveEnvironment($clientId, $clientSecret);
    }

	public static function get_approve_url($response) {
		foreach($response->result->links as $link)
			if ($link->rel == 'approve')
				return $link->href;
	}

	public static function get_order_id($response) {
		return $response->result->id;
	}

	public static function get_taxes_amount($response) {
		return $response->result
						->purchase_units[0]
						->amount->breakdown
						->tax_total
						->value;
	}

	public static function get_total_amount($response) {
		return $response->result->purchase_units[0]->amount->value;
	}

	/**
	 * Capture the order.
	 *
	 * Summary: The seller accepts the payment.
	 *
	 * Requests PayPal to capture the order specified by the order ID provided
	 * by self::order().
	 *
	 * WARNING: Turn "Payment review" to "OFF" in the seller settings!
	 */
	public static function capture($order_id) {
		$request = new OrdersCaptureRequest($order_id);
		$request->prefer('return=representation');
		$client = self::client();
	    return $client->execute($request);
	}

	/**
	 * Create the order.
	 *
	 * Summary: The customer creates the order.
	 *
	 * Requests PayPal to create the order. The response will provide the
	 * link to call to approve the payment (use self::capture() for that).
	 */
	public static function order($params) {
		$scheme = $_SERVER["REQUEST_SCHEME"] ?? 'http';
		$host = $_SERVER['HTTP_HOST'];
		$lang = $params['lang'];

		// Construct a request object and set desired parameters.
		// Here, OrdersCreateRequest() creates a POST request to /v2/checkout/orders
		// SEE: https://developer.paypal.com/docs/api/orders/v2/#definition-order_application_context
		$request = new OrdersCreateRequest();
		$request->prefer('return=representation');
		$request->body = [
			'intent' => 'CAPTURE',
			'application_context' => [
				'brand_name'          => 'Le Loclathon',
				'landing_page'        => 'BILLING',
                'shipping_preference' => 'SET_PROVIDED_ADDRESS',
                'user_action'         => 'CONTINUE',
				'cancel_url'          => "$scheme://$host/$lang/shop",
				'return_url'          => "$scheme://$host/$lang/shop/confirm"
			],
			'purchase_units' => [
				[
					// 'reference_id' => 'locloise',
					'description' => 'Sporting Goods',
					'amount' => [
						'value' => $params['total'],
						'currency_code' => 'CHF',
						'breakdown' => [
							'item_total' => [
								'currency_code' => 'CHF',
								'value' => $params['price'],
							],
							'shipping' => [
								'currency_code' => 'CHF',
								'value' => $params['shipping_fees'],
							],
							'tax_total' => [
								'currency_code' => 'CHF',
								'value' => $params['payment_fees'],
							],
							// 'shipping_discount' =>
							// 	array(
							// 		'currency_code' => 'CHF',
							// 		'value' => '10.00',
							// 	),
						],
					],
					'items' => [
						[
							'name' => 'La Locloise',
							'description' => 'La Locloise, bouteille 5dl officielle du Loclathon.',
							'quantity' => $params['units'],
							'unit_amount' => [
								'currency_code' => 'CHF',
								'value'         => $params['price'] / $params['units']
							]
						],
					],
					'shipping' => [
						'method' => __('shop.shippings')[$params['shipping']],
						'name' => [
							'full_name' => "{$params['first_name']} {$params['last_name']}",
						],
						'address' => [
							'address_line_1' => $params['street'],
							'admin_area_2'   => $params['city'],
							'postal_code'    => $params['npa'],
							'country_code'   => $params['country'],
						],
					],
				]
			],

		];

		$client = self::client();
	    return $client->execute($request);;
	}
}
