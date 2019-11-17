<?php

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
		//On va chercher la session de l'API
		\Stripe\Stripe::setApiKey(STRIPE_PRIVATE_KEY);
		$stripe = \Stripe\Checkout\Session::retrieve($_POST['session_id']);

		if(count($stripe) == 0) throw new Exception("Something went wrong", 500);

		/**
		 * 1 - On met à jour la date de paiement
		 */
		$commandManager = new CommandManager();
		$commandDatas = $commandManager->get($stripe["client_reference_id"]);
		if(count($commandDatas) == 0) throw new Exception("Something went wrong", 500);
		$command = new Command([
			"id"                  => $commandDatas[0]['id'],
			"totalPriceBeforeTax" => $commandDatas[0]['total_price_before_tax'],
			"totalPriceWithTax"   => $commandDatas[0]['total_price_with_tax'],
			"taxAmount"           => $commandDatas[0]['tax_amount'],
			"fkAddress"           => $commandDatas[0]['fk_address'],
			"payedDate"           => date('Y-m-d H:i:s'),
		]);
		$commandId = $commandManager->set($command);

		//On va aussi chercher les lignes de commandes pour les mails
		$commandLineManager = new CommandLineManager();
		$commandDatas[0]["commandLines"] = $commandLineManager->get(null, $stripe["client_reference_id"]);
		$commandDatas[0]["email"] = $stripe['customer_email'];

		/**
		 * 2 - On met a jour les stocks (todo)
		 */
		
		
		/**
		 * 3 - Puis on envoie les emails aux 2 partis
		 */
		$helpers = new Helpers();
		$emailManager = new EmailManager();

		$email = new Email([
			'sender' => 'Soins Des Levres <' . EMAIL_ACCOUNT . '>',
			'recipient' => $commandDatas[0]["email"],
			'subject' => 'Votre achat sur www.soins-des-levres.fr',
			'message' => $helpers->renderTemplate(ROOT.'/emails/orderPaid.php', $commandDatas[0]),
			'fkEmailStatus' => 1
		]);

		$resp = $emailManager->send($email);

		$email = new Email([
			'sender' => $commandDatas[0]["email"],
			'recipient' => 'Soins Des Levres <' . EMAIL_ACCOUNT . '>',
			'subject' => 'Nouvel achat sur www.soins-des-levres.fr',
			'message' => $helpers->renderTemplate(ROOT.'/emails/orderReceived.php', $commandDatas[0]),
			'fkEmailStatus' => 1
		]);

		$resp = $emailManager->send($email);

		echo json_encode($resp);
		die();
	}

}