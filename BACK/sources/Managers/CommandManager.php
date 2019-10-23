<?php

class CommandManager extends Manager {

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

	public function set(Command $command) {
		$sql = "
			INSERT INTO command (
				id,
				creation_date,
				payment_date,
				total_price_before_tax,
				total_price_with_tax,
				tax_amount,
				treated_date,
				sent_date,
				archiving_date
			) VALUES (
				:id,
				:creationDate,
				:paymentDate
				:totalPriceBeforeTax
				:totalPriceWithTax
				:taxAmount
				:treatedDate
				:sentDate
				:archivingDate
			) ON DUPLICATE KEY UPDATE
				payment_date           = VALUES( payment_date ),
				total_price_before_tax = VALUES( total_price_before_tax ),
				total_price_with_tax   = VALUES( total_price_with_tax ),
				tax_amount             = VALUES( tax_amount ),
				treated_date           = VALUES( treated_date ),
				sent_date              = VALUES( sent_date ),
				archiving_date         = VALUES( archiving_date )
		";
		$q = $this->db->prepare($sql);
		$q->bindValue(":id",                  $command->getId());
		$q->bindValue(":creationDate",        $command->getCreationDate());
		$q->bindValue(":paymentDate",         $command->getPaymentDate());
		$q->bindValue(":totalPriceBeforeTax", $command->getTotalPriceBeforeTax());
		$q->bindValue(":totalPriceWithTax",   $command->getTotalPriceWithTax());
		$q->bindValue(":taxAmount",           $command->getTaxAmount());
		$q->bindValue(":treatedDate",         $command->getTreatedDate());
		$q->bindValue(":sentDate",            $command->getSentDate());
		$q->bindValue(":archivingDate",       $command->getArchivingDate());

		if(!$q->execute()) {
			var_dump($q->debugDumpParams());
			http_response_code(400);
			die();
		}
		return is_null($command->getId()) ? $this->db->lastInsertId() : $command->getId();
	}

	public function del($id = null) {
		if(is_null($id)) return false;
		$sql = "
			UPDATE command
			SET command.archiving_date = NOW()
			WHERE command.id = :id
		";
		$q = $this->db->prepare($sql);
		$q->bindValue(':id', $id);
		return $q->execute();
	}
}