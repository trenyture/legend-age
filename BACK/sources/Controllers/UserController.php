<?php

class UserController {

	public function retrieve($userId = null) {
		echo true;
		die();
	}

	public function insert() {
		if(!isset($_POST) || count($_POST) == 0) {
			http_response_code(400);
			echo true;
			die();
		}

		$validator = new Validator();

		$validator->isEmpty($_POST['lastname'], "Le nom");
		$validator->isEmpty($_POST['firstname'], "Le prénom");
		$validator->isEmail($_POST['email'], "L'email");
		$validator->isEmpty($_POST['birth-date'], "La date de naissance");

 		$errors = $validator->hasErrors();

		if($errors !== false) {
			http_response_code(400);
			echo json_encode(["details" => $errors]);
			die();
		}

		$_POST["email"] = strtolower($_POST["email"]);

		$userManager = new UserManager();

		$yetExists = $userManager->get(null, $_POST["email"]);
		if(count($yetExists) > 0) {
			http_response_code(400);
			echo json_encode(["details" => "Un utilisateur ayant cet email existe déjà"]);
			die();
		}

		$helpers = new Helpers();
		$_POST['activation-key'] = $helpers->uuid();

		$user = new User([
			"email"         => $_POST["email"],
			"firstname"     => $_POST["firstname"],
			"lastname"      => $_POST["lastname"],
			"birthDate"     => $_POST["birth-date"],
			"activationKey" => $_POST['activation-key'],
		]);
		$resp = $userManager->set($user);

		var_dump($resp);
		die();

		$emailManager = new EmailManager();
		$email = new Email([
			'sender'        => 'Soins Des Levres <' . EMAIL_ACCOUNT . '>',
			'recipient'     => $_POST['email'],
			'subject'       => "Soins Des Lèvres : Création de votre compte",
			'message'       => $helpers->renderTemplate(ROOT.'/emails/newAccount.php', $_POST),
			'fkEmailStatus' => 1
		]);
		$emailManager->send($email);

		echo json_encode($resp);
		die();
	}

	public function update($userId) {
		/* Les données PUT arrivent du flux */
		$_PUT = fopen("php://input", "r");
		echo json_encode(true);
		die();
	}

	public function delete($userId) {
		echo json_encode(true);
		die();
	}

}