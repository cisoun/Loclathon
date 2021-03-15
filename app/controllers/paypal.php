<?php
/**
 * PayPal controller.
 *
 * Documentation:
 *	- https://github.com/paypal/Checkout-PHP-SDK
 *	- https://developer.paypal.com/docs/checkout/reference/server-integration/setup-sdk/
 */
require_once('vendor/autoload.php');

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

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
    public static function client()
    {
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

	public static function order($params) {
		$host = $_SERVER['SERVER_NAME'];
		$lang = $params['lang'];

		// Construct a request object and set desired parameters
		// Here, OrdersCreateRequest() creates a POST request to /v2/checkout/orders
		use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
		$request = new OrdersCreateRequest();
		$request->prefer('return=representation');
		$request->body = [
			'intent' => 'CAPTURE',
			'purchase_units' => [
				[
					'reference_id' => 'locloise',
					'amount' => [
						'value' => $params['price'],
						'currency_code' => 'CHF'
					]
				]
			],
			'application_context' => [
				'cancel_url' => "$host/$lang/shop/confirmation",
				'return_url' => "$host/$lang/shop"
			]
		];

		try {
		    // Call API with your client and get a response for your call
		    $response = $client->execute($request);

		    // If call returns body in response, you can get the deserialized version from the result attribute of the response
		    print_r($response);
		}catch (HttpException $ex) {
		    echo $ex->statusCode;
		    print_r($ex->getMessage());
		}
	}
}
