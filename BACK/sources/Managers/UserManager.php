<?php

class UserManager extends Manager {

	public function get($id = null, $email = null, $auth = false) {
		$sql = "
			SELECT
				user.id,
				user.email,
				user.firstname,
				user.lastname,
				user.birth_date,
				user.activation_key,
				user.created_date,
				user.archived_date,
				user.newsletter" . ($auth === true ? ",
				user.is_admin,
				password.hash" : "") ."
			FROM user
			LEFT JOIN password
				ON password.fk_user = user.id
				AND password.archived_date IS NULL
			WHERE 1
			".(!is_null($id) ? "AND user.id = :id" : "")."
			".( !is_null($email) ? "AND user.email = :email" : "")."
		";
		$q = $this->db->prepare($sql);
		if(!is_null($id))    $q->bindValue(':id', $id);
		if(!is_null($email)) $q->bindValue(':email', $email);
		if(!$q->execute()) {
			throw new Exception("Problème lors de la récupération de l'utilisateur", 400);
		}
		$users = [];
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){
			$users[] = $donnees;
		}
		return $users; 
	}

	public function set(User $user) {
		$sql = "
			INSERT INTO user(
				id,
				email,
				firstname,
				lastname,
				birth_date,
				activation_key,
				created_date,
				archived_date,
				newsletter,
				is_admin
			) VALUES (
				:id,
				:email,
				:firstname,
				:lastname,
				:birthDate,
				:activationKey,
				:createdDate,
				:archivedDate,
				:newsletter,
				:isAdmin
			) ON DUPLICATE KEY UPDATE
				id             = VALUES( id ),
				email          = VALUES( email ),
				firstname      = VALUES( firstname ),
				lastname       = VALUES( lastname ),
				birth_date     = VALUES( birth_date ),
				activation_key = VALUES( activation_key ),
				created_date   = VALUES( created_date ),
				archived_date  = VALUES( archived_date ),
				newsletter     = VALUES( newsletter ),
				is_admin       = VALUES( is_admin );
		";
		$q = $this->db->prepare($sql);
		$q->bindValue(":id",            $user->getId());
		$q->bindValue(":email",         $user->getEmail());
		$q->bindValue(":firstname",     $user->getFirstname());
		$q->bindValue(":lastname",      $user->getLastname());
		$q->bindValue(":birthDate",     $user->getBirthDate());
		$q->bindValue(":activationKey", $user->getActivationKey());
		$q->bindValue(":createdDate",   $user->getCreatedDate());
		$q->bindValue(":archivedDate",  $user->getArchivedDate());
		$q->bindValue(":newsletter",    $user->getNewsletter());
		$q->bindValue(":isAdmin",       $user->getIsAdmin());
		if(!$q->execute()) {
			throw new Exception("Problème lors de la sauvegarde de l'utilisateur", 400);
		}
		return is_null($user->getId()) ? $this->db->lastInsertId() : $user->getId();
	}

	public function del($id = null, $email = null) {
		if(is_null($id) && is_null($email)) return false;

		$sql = "
			DELETE FROM user
			WHERE 1
			".(!is_null($id)    ? "AND user.id = :id"       : "")."
			".(!is_null($email) ? "AND user.email = :email" : "")."
		";
		$q = $this->db->prepare($sql);
		if(!is_null($id))    $q->bindValue(':id', $id);
		if(!is_null($email)) $q->bindValue(':email', $email);
		if(!$q->execute()) {
			throw new Exception("Problème lors de la sauvegarde de l'utilisateur", 400);
		}
		return true;
	}
}