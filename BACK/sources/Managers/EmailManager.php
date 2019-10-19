<?php


class EmailManager extends Manager {

	public function set() {
		$sql = "
			INSERT INTO
				produits(
					titre_produit,
					description_produit,
					prix_produit,
					date_creation_produit
				)
			VALUES
				(
					:titreProduit,
					:descriptionProduit,
					:prixProduit,
					:dateCreationProduit
				)
		";
		$q = $this->db->prepare($sql);
		$q->bindValue(':titreProduit', $produit->getTitreProduit());
		$q->bindValue(':descriptionProduit', $produit->getDescriptionProduit());
		$q->bindValue(':prixProduit', $produit->getPrixProduit());
		$q->bindValue(':dateCreationProduit', $produit->getDateCreationProduit());
		return $q->execute();
	}

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

		$emailManager = new EmailManager();
		

		echo json_encode($_POST);
		die();
	}

}