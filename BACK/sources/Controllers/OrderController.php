<?php

class OrderController {

	public function create() {
		if(!isset($_POST) || count($_POST) == 0 || !isset($_POST['ordered_quantity']) || count($_POST['ordered_quantity']) == 0) {
			throw new Exception("Une erreur s'est produite veuillez rééssayer ultérieurement.", 400);
		}

		$validator = new Validator();
		$validator->isEmpty($_POST['recipient'], "Le nom");
		$validator->isEmail($_POST['email'], "L'email");
		$validator->isPhone($_POST['phone_number'], "Le téléphone");
		$validator->isEmpty($_POST['street'], "L'adresse");
		$validator->isPostCode($_POST['postcode'], "Le code postal");
		$validator->isEmpty($_POST['city'], "La ville");
		$validator->isEmpty($_POST['fk_country'], "Le pays");
		
 		$errors = $validator->hasErrors();
		if($errors !== false) {
			http_response_code(400);
			echo json_encode(["details" => $errors]);
			die();
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
				$amount = $_POST['ordered_quantity'][$i] * ($_POST['fk_product'][$i] == 2 ? 99.00 : (!is_null(PROMO) ? 29.00 - PROMO : 29.00));
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
			$dbh = new Manager();
			$dbh->db->beginTransaction();

			/**
			 * 1 - On va créer l'adresse
			 */
			$addressManager = new AddressManager();
			$address = new Address([
				'recipient'   => $_POST['recipient'],
				'email'       => $_POST['email'],
				'phoneNumber' => $_POST['phone_number'],
				'street'      => $_POST['street'],
				'postcode'    => $_POST['postcode'],
				'city'        => $_POST['city'],
				'fkCountry'   => $_POST['fk_country']
			]);
			$addressId = $addressManager->set($address);

			/**
			 * 2 - Puis la commande
			 */
			$commandManager = new CommandManager();
			$command = new Command([
				"totalPriceBeforeTax" => $totalPriceBeforeTax,
				"totalPriceWithTax"   => $totalPriceWithTax,
				"taxAmount"           => $taxAmount,
				"fkAddress"           => $addressId
			]);
			$commandId = $commandManager->set($command);

			/* 
			 * 3 - Puis les lignes de commande
			 */
			$commandLineManager = new CommandLineManager();
			$commandLineIds = [];
			for ($i=0; $i < count($_POST['ordered_quantity']); $i++) {
				$commandLine = new CommandLine([
					"orderedQuantity" => $_POST['ordered_quantity'][$i],
					"fkProduct" => $_POST['fk_product'][$i],
					"fkCommand" => $commandId
				]);
				array_push($commandLineIds, $commandLineManager->set($commandLine));
			}
			
			/*
			 * 4 - Enfin on va utiliser Stripe
			 */
			try {
				\Stripe\Stripe::setApiKey(STRIPE_PRIVATE_KEY);
				$session = \Stripe\Checkout\Session::create([
					"client_reference_id" => $commandId,
					'customer_email' => $_POST['email'],
					'payment_method_types' => ['card'],
					'line_items' => $commandLines,
					'success_url' => FRONT_URL . 'order/{CHECKOUT_SESSION_ID}',
					'cancel_url' => FRONT_URL . 'basket',
					'billing_address_collection' => 'auto',
					'locale' => 'fr',
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
			$dbh->db->commit();
			echo json_encode(['stripe_id' => $session->id]);
		} catch (Exception $e) {
			$dbh->db->rollBack();
			http_response_code($e->getCode());
			$resp = ["details" => ["Il y a eu un problème lors de la sauvegarde de la commande"]];
			if(ENV != "prod") {
				$resp["stack"] = $e->getTraceAsString();
			}
			echo json_encode($resp);
			die();
		}
	}

	public function update() {
		/* Les données PUT arrivent du flux */
		/**
		 * 1 - On met à jour la date de paiement
		 * 2 - Puis on envoie les emails aux 2 partis
		 * 3 - On renvoit TRUE
		 */
		//On va chercher la session de l'API
		\Stripe\Stripe::setApiKey('sk_test_mGoXrTuaWJTdzfihHOw4N5hj00dMlVlDvy');

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