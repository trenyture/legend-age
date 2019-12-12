<?php

class LoginController {

	public function signin() {
		if(!isset($_POST['email']) || !isset($_POST['password'])) {
			throw new Exception("Page not found", 404);
		}
		$userManager = new UserManager();
		$user = $userManager->get(null, trim(strtolower($_POST['email'])), true);

		if(count($user) === 0) {
			throw new Exception("Identifiant incorrect", 400);
		}

		if(is_null($user[0]['hash'])) {
			throw new Exception("Utilisateur inactif", 400);
		}

		if(!password_verify($_POST['password'], $user[0]['hash'])) {
			throw new Exception("Mot de passe incorrect", 1);
		}

		echo json_encode(["user" => [
			"user_id"  => $user[0]['id'],
			"is_admin" => $user[0]['is_admin'],
		]]);
	}

	public function newPassword() {
		echo json_encode(["response" => "Logged"]);
		die();
	}

	public function logout() {
		echo json_encode(["response" => "Logout"]);
		die();
	}

}