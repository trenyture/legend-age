<?php

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;

class PayPalClient
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
	 * This sample uses SandboxEnvironment. In production, use ProductionEnvironment.
	 */
	public static function environment()
	{
		return (ENV === "prod") ? new ProductionEnvironment(PAYPAL_CLIENT_ID, PAYPAL_PRIVATE_KEY) : new SandboxEnvironment(PAYPAL_CLIENT_ID, PAYPAL_PRIVATE_KEY);
	}
}