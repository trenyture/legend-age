<?php

class CommandLineManager extends Manager {

	public function get($id = null, $commandId = null) {
		$sql = "
			SELECT
				command.*,
				command_line.*
			FROM command_line
			INNER JOIN command
				ON command.id = command_line.fk_command
			WHERE 1
			AND command.archived_date IS NULL
			".(!is_null($id) ? "AND command_line.id = :id" : "")."
			".(!is_null($commandId) ? "AND command.id = :commandId" : "")."
		";
		$q = $this->db->prepare($sql);
		if(!is_null($id))        $q->bindValue(':id', $id);
		if(!is_null($commandId)) $q->bindValue(':commandId', $commandId);
		if(!$q->execute()) {
			throw new Exception("Problème lors de la récupération en base de donnée", 500);
		}
		$datas = [];
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){
			$datas[] = $donnees;
		}
		return $datas;
	}

	public function set(CommandLine $commandLine) {
		$sql = "
			INSERT INTO command_line (
				id,
				created_date,
				ordered_quantity,
				fk_command,
				fk_product
			) VALUES (
				:id,
				:createdDate,
				:orderedQuantity,
				:fkCommand,
				:fkProduct
			) ON DUPLICATE KEY UPDATE
				id               = VALUES( id ),
				created_date     = VALUES( created_date ),
				ordered_quantity = VALUES( ordered_quantity ),
				fk_command       = VALUES( fk_command ),
				fk_product       = VALUES( fk_product );
		";
		$q = $this->db->prepare($sql);
		$q->bindValue(":id",              $commandLine->getId());
		$q->bindValue(":createdDate",     $commandLine->getCreatedDate());
		$q->bindValue(":orderedQuantity", $commandLine->getOrderedQuantity());
		$q->bindValue(":fkCommand",       $commandLine->getFkCommand());
		$q->bindValue(":fkProduct",       $commandLine->getFkProduct());

		if(!$q->execute()) {
			throw new Exception("Problème lors de la sauvegarde de la ligne de commande", 400);
		}
		return is_null($commandLine->getId()) ? $this->db->lastInsertId() : $commandLine->getId();
	}

	public function del($id = null, $commandId = null) {
		if(is_null($id) && is_null($commandId)) return false;

		$sql = "
			DELETE command_line
			FROM command_line
			INNER JOIN command
				ON command.id = command_line.fk_command
			WHERE 1
			".(!is_null($id) ? "AND command_line.id = :id" : "")."
			".(!is_null($commandId) ? "AND command.id = :commandId" : "")."
		";
		$q = $this->db->prepare($sql);
		if(!is_null($id))        $q->bindValue(':id', $id);
		if(!is_null($commandId)) $q->bindValue(':commandId', $commandId);
		if(!$q->execute) {
			throw new Exception("Problème lors de la suppression de la ligne de commande", 400);
		}
		return true;
	}
}