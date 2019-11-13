<?php

class EmailManager extends Manager {

	public function get($id = null, $fkEmailStatus = null) {
		$sql = "
			SELECT
				email_pool.*,
				email_status.id AS status_id,
				email_status.label AS status_label
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
		if(!$q->execute()) {
			throw new Exception("Problème lors de la récupération en base de donnée", 500);
		}
		$datas = [];
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){
			$datas[] = $donnees;
		}
		return $datas;
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
		$q->bindValue(':id',            $email->getId());
		$q->bindValue(':sender',        $email->getSender());
		$q->bindValue(':alias',         $email->getAlias());
		$q->bindValue(':recipient',     $email->getRecipient());
		$q->bindValue(':subject',       $email->getSubject());
		$q->bindValue(':message',       $email->getMessage());
		$q->bindValue(':error',         $email->getError());
		$q->bindValue(':sentDate',      $email->getSentDate());
		$q->bindValue(':fkEmailStatus', $email->getFkEmailStatus());
		if(!$q->execute()) {
			throw new Exception("Problème lors de la sauvegarde de l'email", 400);
		}
		return is_null($email->getId()) ? $this->db->lastInsertId() : $email->getId();
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
		if(!is_null($id))            $q->bindValue(':id', $id);
		if(!is_null($fkEmailStatus)) $q->bindValue(':fkEmailStatus', $fkEmailStatus);
		if(!$q->execute()) {
			throw new Exception("Problème lors de la suppression de l'email", 400);
		}
		return true;
	}

	public function send($email) {
		$headers   = [];
		$headers[] = 'From: ' . $email->getSender();
		$headers[] = 'Reply-To: ' . $email->getSender();
		$headers[] = 'Bcc: simon.trichereau@gmail.com';
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-Type: text/html; charset=ISO-8859-1';
		$headers[] = 'X-Mailer: PHP/' . phpversion();

		if(mail(
			$email->getRecipient(),
			$email->getSubject(),
			$email->getMessage(),
			implode("\r\n", $headers)
		)) {
			return true;
		} else {
			return false;
		}
	}
}