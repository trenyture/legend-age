<?php

class AddressManager extends Manager {

	public function get($id = null) {
		$sql = "
			SELECT *
			FROM address
			WHERE 1
			AND address.archived_date IS NULL
			".(!is_null($id) ? "AND country.id = :id" : "")."
		";
		$q = $this->db->prepare($sql);
		if(!is_null($id)) $q->bindValue(':id', $id);
		$q->execute();
		$addresses = [];
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){
			$addresses[] = $donnees;
		}
		return $addresses;
	}

	public function set(Address $address) {
		$sql = "
			INSERT INTO address (
				id,
				label,
				recipient,
				street,
				complement,
				delivery_instructions,
				postcode,
				city,
				phone_number,
				created_date,
				archived_date,
				fk_country
			) VALUES 
				:id,
				:label,
				:recipient,
				:street,
				:complement,
				:deliveryInstructions,
				:postcode,
				:city,
				:phoneNumber,
				:createdDate,
				:archivedDate,
				:fkCountry
			) ON DUPLICATE KEY UPDATE
				label                 = VALUES( label ),
				recipient             = VALUES( recipient ),
				street                = VALUES( street ),
				complement            = VALUES( complement ),
				delivery_instructions = VALUES( delivery_instructions ),
				postcode              = VALUES( postcode ),
				city                  = VALUES( city ),
				phone_number          = VALUES( phone_number )
				fk_country            = VALUES( fk_country );
		";
		$q = $this->db->prepare($sql);

		$q->bindValue(":id", $address->getId());
		$q->bindValue(":label", $address->getLabel());
		$q->bindValue(":recipient", $address->getRecipient());
		$q->bindValue(":street", $address->getStreet());
		$q->bindValue(":complement", $address->getComplement());
		$q->bindValue(":deliveryInstructions", $address->getDeliveryInstructions());
		$q->bindValue(":postcode", $address->getPostcode());
		$q->bindValue(":city", $address->getCity());
		$q->bindValue(":phoneNumber", $address->getPhoneNumber());
		$q->bindValue(":createdDate", $address->getCreatedDate());
		$q->bindValue(":archivedDate", $address->getArchivedDate());
		$q->bindValue(":fkCountry", $address->getFkCountry());

		if(!$q->execute()) {
			http_response_code(400);
			echo true;
			die();
		}
		return is_null($address->getId()) ? $this->db->lastInsertId() : $address->getId();
	}

	public function del($id) {
		$sql = "
			UPDATE address
			SET address.archived_date = NOW()
			WHERE address.id = :id
		";
		$q = $this->db->prepare($sql);
		$q->bindValue(':id', $id);
		if(!$q->execute()) {
			http_response_code(400);
			echo true;
			die();
		}
		return true;
	}

}