<?php

class OrderController {

	public function create() {
		if(!isset($_POST) || count($_POST) == 0) {
			http_response_code(400);
			echo true;
			die();
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
			"totalPriceBeforeTax" => $_POST[],
			"totalPriceWithTax"   => $_POST[],
			"taxAmount"           => $_POST[],
			"treatedDate"         => $_POST[],
			"sentDate"            => $_POST[],
			"archivedDate"        => $_POST[],
			"fkAddress"           => $addressId
		]);
		$commandId = $CommandManager->set($command);

		return;

		\Stripe\Stripe::setApiKey(STRIPE_PRIVATE_KEY);

		return;
		/* 
		 * 3 - Puis les lignes de commande
		 * 4 - Enfin on va utiliser Stripe
		 */
		$session = \Stripe\Checkout\Session::create([
			'payment_method_types' => ['card'],
			'line_items' => [[
				'name' => 'T-shirt',
				'description' => 'Comfortable cotton t-shirt',
				'images' => ['https://example.com/t-shirt.png'],
				'amount' => 500,
				'currency' => 'eur',
				'quantity' => 1,
			]],
			'success_url' => 'https://example.com/success?session_id={CHECKOUT_SESSION_ID}',
			'cancel_url' => 'https://example.com/cancel',
		]);
	}

	public function update($id) {

		/**
		 * 1 - On met à jour la date de paiement
		 * 2 - Puis on envoie les emails aux 2 partis
		 * 3 - On renvoit TRUE
		 */
		$helpers = new Helpers();
		$emailManager = new EmailManager();

		$email = new Email([
			'sender' => $_POST['email'],
			'recipient' => EMAIL_ACCOUNT,
			'subject' => 'Contact : ' . $_POST['subject'],
			'message' => $helpers->renderTemplate(ROOT.'/emails/contact.php', $_POST),
			'fkEmailStatus' => 1
		]);

		$resp = $emailManager->set($email);



		echo json_encode($resp);
		die();
	}

}