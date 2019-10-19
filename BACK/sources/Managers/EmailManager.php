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

}