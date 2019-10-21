<?php


class EmailController {

	public function contact() {
		if(!isset($_POST) || count($_POST) == 0) {
			http_response_code(400);
			die();
		}

		$validator = new Validator();
		$validator->isEmpty($_POST['name'], "Le nom");
		$validator->isEmail($_POST['email'], "L'email");
		$validator->isEmpty($_POST['subject'], "Le sujet");
		$validator->isEmpty($_POST['message'], "Le message");

 		$errors = $validator->hasErrors();
		if($errors !== false) {
			http_response_code(400);
			echo json_encode(["details" => $errors]);
			die();
		}

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