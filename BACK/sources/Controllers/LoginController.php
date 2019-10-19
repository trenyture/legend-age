<?php

class LoginController {

	public function signin() {
		echo json_encode(["response" => "Logged"]);
		die();
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