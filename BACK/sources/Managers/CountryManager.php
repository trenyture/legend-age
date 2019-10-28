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
		if(!$q->execute()) {
			throw new Exception("Problème lors de la récupération en base de donnée", 500);
		}
		$datas = [];
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){
			$datas[] = $donnees;
		}
		return $datas;
	}
}