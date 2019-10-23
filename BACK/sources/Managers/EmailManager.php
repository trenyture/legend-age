<?php

class EmailManager extends Manager {

	public function get($id = null, $fkEmailStatus = null) {
		$sql = "
			SELECT
				email_pool.*,
				JSON_OBJECT(
					'id', email_status.id,
					'label', email_status.label
				) AS status
			FROM email_pool
			LEFT JOIN email_status
				ON email_status.id = email_pool.fk_email_status
			WHERE 1
			".(!is_null($id) ? "AND email_pool.id = :id" : "")."
			".(!is_null($fkEmailStatus) ? "AND email_pool.fk_email_status = :fkEmailStatus" : "")."
		";
		$q = $this->db->prepare($sql);
		if(!is_null($id)) $q->bindValue(':id', $id);
		if(!is_null($fkEmailStatus)) $q->bindValue(':fkEmailStatus', $fkEmailStatus);
		return $q->execute();
	}

	public function set(Email $email) {
		$sql = "
			INSERT INTO email_pool(
				id,
				sender,
				alias,
				recipient,
				subject,
				message,
				error,
				sent_date,
				fk_email_status
			) VALUES (
				:id,
				:sender,
				:alias,
				:recipient,
				:subject,
				:message,
				:error,
				:sentDate,
				:fkEmailStatus
			) ON DUPLICATE KEY UPDATE
				error           = VALUES(error),
				sent_date       = VALUES(sent_date),
				fk_email_status = VALUES(fk_email_status);
		";
		$q = $this->db->prepare($sql);
		$q->bindValue(':id', $email->getId());
		$q->bindValue(':sender', $email->getSender());
		$q->bindValue(':alias', $email->getAlias());
		$q->bindValue(':recipient', $email->getRecipient());
		$q->bindValue(':subject', $email->getSubject());
		$q->bindValue(':message', $email->getMessage());
		$q->bindValue(':error', $email->getError());
		$q->bindValue(':sentDate', $email->getSentDate());
		$q->bindValue(':fkEmailStatus', $email->getFkEmailStatus());
		return $q->execute();
	}

	public function del($id = null, $fkEmailStatus = null) {
		if(is_null($id) && is_null($fkEmailStatus)) return false;

		$sql = "
			DELETE FROM email_pool
			WHERE 1
			".(!is_null($id) ? "AND email_pool.id = :id" : "")."
			".(!is_null($fkEmailStatus) ? "AND email_pool.fk_email_status = :fkEmailStatus" : "")."
		";
		$q = $this->db->prepare($sql);
		if(!is_null($id)) $q->bindValue(':id', $id);
		if(!is_null($fkEmailStatus)) $q->bindValue(':fkEmailStatus', $fkEmailStatus);
		return $q->execute();
	}
}