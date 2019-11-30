<?php

class CommentManager extends Manager {

	public function get($id = null, $validated = true, $archived = false) {
		$sql = "
			SELECT *
			FROM comment
			WHERE 1
			".(!is_null($id)        ? "AND comment.id = :id" : "")."
			".(!is_null($validated) ? "AND comment.validated_date IS " . ($validated == true ? "NOT" : "") . " NULL" : "")."
			".(!is_null($archived)  ? "AND comment.archived_date IS " . ($archived == true ? "NOT" : "") . " NULL" : "")."
		";
		$q = $this->db->prepare($sql);
		if(!is_null($id)) $q->bindValue(':id', $id);
		if(!$q->execute()){
			throw new Exception("Problème lors de la récupération en base de donnée", 500);
		}
		$comments = [];
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){
			$comments[] = $donnees;
		}
		return $comments;
	}

	public function set(Comment $comment) {
		$sql = "
			INSERT INTO comment (
				id,
				firstname,
				lastname,
				message,
				created_date,
				validated_date,
				archived_date
			) VALUES (
				:id,
				:firstname,
				:lastname,
				:message,
				:createdDate,
				:validatedDate,
				:archivedDate
			) ON DUPLICATE KEY UPDATE
				firstname      = VALUES( firstname ),
				lastname       = VALUES( lastname ),
				message        = VALUES( message ),
				created_date   = VALUES( created_date ),
				validated_date = VALUES( validated_date ),
				archived_date  = VALUES( archived_date );
		";
		$q = $this->db->prepare($sql);

		$q->bindValue(":id", $comment->getId());
		$q->bindValue(":firstname", $comment->getFirstname());
		$q->bindValue(":lastname", $comment->getLastname());
		$q->bindValue(":message", $comment->getMessage());
		$q->bindValue(":createdDate", $comment->getCreatedDate());
		$q->bindValue(":validatedDate", $comment->getValidatedDate());
		$q->bindValue(":archivedDate", $comment->getArchivedDate());

		if(!$q->execute()) {
			throw new Exception("Problème lors de la sauvegarde du commentaire", 500);
		}
		return is_null($comment->getId()) ? $this->db->lastInsertId() : $comment->getId();
	}

	public function del($id) {
		$sql = "
			UPDATE comment
			SET comment.archived_date = NOW()
			WHERE comment.id = :id
		";
		$q = $this->db->prepare($sql);
		$q->bindValue(':id', $id);
		if(!$q->execute()) {
			throw new Exception("Problème lors de la suppression du commentaire", 500);
		}
		return true;
	}

}