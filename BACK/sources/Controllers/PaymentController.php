<?php

use PayPalCheckoutSdk\Orders\OrdersGetRequest;

class PaymentController {

	public function create() {

		if(!isset($_POST) || count($_POST) == 0 || !isset($_POST['ordered_quantity']) || count($_POST['ordered_quantity']) == 0) {
			throw new Exception("Une erreur s'est produite veuillez rééssayer ultérieurement.", 400);
		}

		$commandLines = [];
		$totalPriceBeforeTax = 0;
		$totalPriceWithTax = 0;
		$taxAmount = 0;
		for ($i=0; $i < count($_POST['ordered_quantity']); $i++) {
			if($_POST['ordered_quantity'] > 0) {
				$item = [];
				$item['quantity'] = $_POST['ordered_quantity'][$i];
				$item['name'] = "Beaume à lèvre";
				$item['currency'] = "eur";
				$item['description'] = $_POST['ordered_quantity'][$i] .
					($_POST['fk_product'][$i] == 2
						? ' lot'.($_POST['ordered_quantity'][$i] > 1 ? 's' : '').' de 4 exemplaires'
						: ' exemplaire'.($_POST['ordered_quantity'][$i] > 1 ? 's' : '')). ' du beaume magique Legend Age' ;
				$unitPrice = $_POST['fk_product'][$i] == 2 ? 99.00 : 29.00;
				if(!is_null(PROMO) && $_POST['fk_product'][$i] == 1) {
					$unitPrice = $unitPrice - PROMO;
				}
				$amount = $unitPrice;
				$totalPriceWithTax += $amount;
				$totalPriceBeforeTax += $amount / 1.2;
				$taxAmount += $amount * 0.2;
				$item['amount'] = $amount * 100;
				array_push($commandLines, $item);
			}
		}

		if(count($commandLines) == 0) {
			throw new Exception("Vous devez commander des produits", 401);
		}

		try {
			\Stripe\Stripe::setApiKey(STRIPE_PRIVATE_KEY);
			$session = \Stripe\Checkout\Session::create([
				'payment_method_types' => ['card'],
				'line_items' => $commandLines,
				'success_url' => FRONT_URL . 'order/confirmed/stripe/{CHECKOUT_SESSION_ID}',
				'cancel_url' => FRONT_URL . 'basket',
				'locale' => 'fr',
				'billing_address_collection' => 'required',
			]);
		} catch(\Stripe\Exception\CardException $e) {
			throw $e;
		} catch (\Stripe\Exception\RateLimitException $e) {
			throw $e;
		} catch (\Stripe\Exception\InvalidRequestException $e) {
			throw $e;
		} catch (\Stripe\Exception\AuthenticationException $e) {
			throw $e;
		} catch (\Stripe\Exception\ApiConnectionException $e) {
			throw $e;
		} catch (\Stripe\Exception\ApiErrorException $e) {
			throw $e;
		} catch (Exception $e) {
			throw $e;
		}
		echo json_encode(['stripe_id' => $session->id]);
	}

	public function update() {
		$order = [];

		if(!isset($_POST, $_POST["session_id"], $_POST["payer"], $_POST["ordered_quantity"], $_POST["fk_product"]) || ($_POST["payer"] !== "paypal" && $_POST["payer"] !== "stripe")) {
			throw new Exception("Quelque chose à mal tourné", 500);
		}

		/*
		 * Allons chercher les infos dans l'API stripe
		 */
		if($_POST["payer"] === "stripe") {
			try {
				\Stripe\Stripe::setApiKey(STRIPE_PRIVATE_KEY);
				$stripe = \Stripe\Checkout\Session::retrieve($_POST['session_id']);
				if(count($stripe) == 0) throw new Exception("Quelque chose à mal tourné", 500);

				$payment = \Stripe\PaymentIntent::retrieve($stripe["payment_intent"]);
				if(count($payment) == 0 || $payment["status"] !== "succeeded") throw new Exception("Quelque chose à mal tourné", 500);

				$customer = \Stripe\Customer::retrieve($payment["customer"]);
				if(count($customer) == 0) throw new Exception("Quelque chose à mal tourné", 500);

				$charge = \Stripe\Charge::retrieve($payment["charges"]["data"][0]["id"]);
				if(count($charge) == 0) throw new Exception("Quelque chose à mal tourné", 500);

				$order["email"]      = $charge["billing_details"]["email"];
				$order["recipient"]  = $charge["billing_details"]["name"];
				$order["street"]     = $charge["billing_details"]["address"]["line1"];
				$order["complement"] = $charge["billing_details"]["address"]["line2"];
				$order["postcode"]   = $charge["billing_details"]["address"]["postal_code"];
				$order["city"]       = $charge["billing_details"]["address"]["city"];
				$order["country"]    = $charge["billing_details"]["address"]["country"];
				$order["fk_country"] = 77; // - France

			}
			catch (Exception $e) {
				throw new Exception("Quelque chose à mal tourné", 500);
			}
		}

		elseif ($_POST["payer"] === "paypal") {
			try {
				$paypalClient = new PaypalClient();
				$client = $paypalClient::client();
				$response = $client->execute(new OrdersGetRequest($_POST['session_id']));
				if(!isset($response->result) || $response->result->status !== "COMPLETED") throw new Exception("Quelque chose à mal tourné", 500);
				$result = $response->result;

				$order["email"]      = $result->payer->email_address;
				$order["recipient"]  = $result->purchase_units[0]->shipping->name->full_name;
				$order["street"]     = $result->purchase_units[0]->shipping->address->address_line_1;
				$order["complement"] = (isset($result->purchase_units[0]->shipping->address->address_line_2))
					? $result->purchase_units[0]->shipping->address->address_line_2
					: null;
				$order["postcode"]   = $result->purchase_units[0]->shipping->address->postal_code;
				$order["city"]       = $result->purchase_units[0]->shipping->address->admin_area_2;
				$order["country"]    = $result->purchase_units[0]->shipping->address->country_code;
				$order["fk_country"] = 77; // - France

			}
			catch (Exception $e) {
				throw new Exception("Quelque chose à mal tourné", 500);
			}
		}

		if(count($order) === 0) {
			throw new Exception("Quelque chose à mal tourné", 500);
		}

		$order["commandLines"] = [];
		$order["total_price_with_tax"] = 0;
		for ($i=0; $i < count($_POST['ordered_quantity']); $i++) {
			if($_POST['ordered_quantity'] > 0) {
				$item = [];
				$item['ordered_quantity'] = $_POST['ordered_quantity'][$i];
				$item['fk_product'] = $_POST['fk_product'][$i];
				array_push($order["commandLines"], $item);
				$order["total_price_with_tax"] += $_POST['ordered_quantity'][$i] * ($_POST['fk_product'][$i] == 2 ? 99.00 : (!is_null(PROMO) ? 29.00 - PROMO : 29.00));
			}
		}

		/**
		 * ON ENVOIT LES EMAILS
		 */
		$helpers = new Helpers();
		$emailManager = new EmailManager();
		try {
			$email = new Email([
				'sender' => $order["recipient"] . " <" . $order["email"] . ">",
				'recipient' => 'Soins Des Levres <' . EMAIL_ACCOUNT . '>',
				'subject' => 'Nouvel achat sur www.soins-des-levres.fr',
				'message' => $helpers->renderTemplate(ROOT.'/emails/orderReceived.php', $order),
				'fkEmailStatus' => 1
			]);
			$resp = $emailManager->send($email);
		} catch (Exception $e) {
			throw new Exception("Quelque chose à mal tourné lors de l'envoi de l'email", 500);
		}

		try {
			$email = new Email([
				'sender' => 'Soins Des Levres <' . EMAIL_ACCOUNT . '>',
				'recipient' => $order["recipient"] . " <" . $order["email"] . ">",
				'subject' => 'Votre achat sur www.soins-des-levres.fr',
				'message' => $helpers->renderTemplate(ROOT.'/emails/orderPaid.php', $order),
				'fkEmailStatus' => 1
			]);
			$resp = $emailManager->send($email);
		} catch (Exception $e) {
			throw new Exception("Quelque chose à mal tourné lors de l'envoi de l'email", 500);
		}


		/**
		 * ON GARDE EN BASE LES LIGNES DE COMMANDE
		 */

		/**
		 * ON GARDE EN BASE L'ADRESSE
		 */

		/**
		 * ON GARDE EN BASE LA COMMANDE
		 */

		/**
		 * ON MET A JOUR LE STOCK
		 */

		echo json_encode(true);
		die();
	}

}