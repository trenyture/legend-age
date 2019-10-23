<?php

class CountryManager extends Manager {

	public function get($id = null) {
		$sql = "
			SELECT *
			FROM country
			WHERE 1
			".(!is_null($id) ? "AND country.id = :id" : "")."
		";
		$q = $this->db->prepare($sql);
		if(!is_null($id)) $q->bindValue(':id', $id);
		$q->execute();
		$countries = [];
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){
			$countries[] = $donnees;
		}
		return $countries;
	}
}