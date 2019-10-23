<?php

class CommandManager extends Manager {

	public function get($id = null) {
		$sql = "
			SELECT *
			FROM command
			WHERE 1
			AND command.archived_date IS NULL
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

	public function set(Command $command) {
		$sql = "
			INSERT INTO command (
				id,
				created_date,
				payed_date,
				total_price_before_tax,
				total_price_with_tax,
				tax_amount,
				treated_date,
				sent_date,
				archived_date,
				fk_address
			) VALUES (
				:id,
				:createdDate,
				:payedDate
				:totalPriceBeforeTax
				:totalPriceWithTax
				:taxAmount
				:treatedDate
				:sentDate
				:archivedDate,
				:fkAddress
			) ON DUPLICATE KEY UPDATE
				payed_date             = VALUES( payed_date ),
				total_price_before_tax = VALUES( total_price_before_tax ),
				total_price_with_tax   = VALUES( total_price_with_tax ),
				tax_amount             = VALUES( tax_amount ),
				treated_date           = VALUES( treated_date ),
				sent_date              = VALUES( sent_date ),
				fk_address             = VALUES( fk_address );
		";
		$q = $this->db->prepare($sql);
		$q->bindValue(":id",                  $command->getId());
		$q->bindValue(":createdDate",         $command->getCreatedDate());
		$q->bindValue(":payedDate",           $command->getPayedDate());
		$q->bindValue(":totalPriceBeforeTax", $command->getTotalPriceBeforeTax());
		$q->bindValue(":totalPriceWithTax",   $command->getTotalPriceWithTax());
		$q->bindValue(":taxAmount",           $command->getTaxAmount());
		$q->bindValue(":treatedDate",         $command->getTreatedDate());
		$q->bindValue(":sentDate",            $command->getSentDate());
		$q->bindValue(":archivedDate",        $command->getArchivedDate());
		$q->bindValue(":fkAddress",           $command->getFkAddress());

		if(!$q->execute()) {
			var_dump($q->debugDumpParams());
			http_response_code(400);
			die();
		}
		return is_null($command->getId()) ? $this->db->lastInsertId() : $command->getId();
	}

	public function del($id) {
		$sql = "
			UPDATE command
			SET command.archived_date = NOW()
			WHERE command.id = :id
		";
		$q = $this->db->prepare($sql);
		$q->bindValue(':id', $id);
		return $q->execute();
	}
}