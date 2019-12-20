<?php

class CommentController {

	public function retrieve($commentId = null) {
		$commentManager = new CommentManager();

		$validated = isset($_GET['validated']) ? (strtolower($_GET['validated']) === 'null' ? null : $_GET['validated']) : true;
		$archived = isset($_GET['archived'])   ? (strtolower($_GET['archived']) === 'null' ? null : $_GET['archived']) : false;

		echo json_encode($commentManager->get($commentId, $validated, $archived));
		die();
	}

	public function insert() {

		$commentManager = new CommentManager();

		$comment = new Comment([
			"firstname"     => $_POST['firstname'],
			"lastname"      => $_POST['lastname'],
			"notation"      => $_POST['notation'],
			"message"       => $_POST['message'],
			"createdDate"   => date('Y-m-d h:i:s'),
		]);

		$commentId = $commentManager->set($comment);
		echo json_encode($commentId);
		die();
	}

	public function update($commentId) {
		/* Les données PUT arrivent du flux */
		$_PUT = json_decode(file_get_contents('php://input'), true);
		/**
		 * On va récupérer les anciennes données
		 */
		$commentManager = new CommentManager();
		$oldComment = $commentManager->get($commentId, null, null);
		if(!isset($oldComment) || count($oldComment) == 0) {
			throw new Exception("Vous devez commander des produits", 401);
		}
		$oldComment = $oldComment[0];



		$comment = new Comment([
			"id"            => $oldComment['id'],
			"firstname"     => isset($_PUT['firstname']) ? $_PUT['firstname'] : $oldComment['firstname'],
			"lastname"      => isset($_PUT['lastname']) ? $_PUT['lastname'] : $oldComment['lastname'],
			"notation"      => isset($_PUT['notation']) ? $_PUT['notation'] : $oldComment['notation'],
			"message"       => isset($_PUT['message']) ? $_PUT['message'] : $oldComment['message'],
			"createdDate"   => $oldComment['created_date'],
			"validatedDate" => isset($_PUT['validated_date']) ? $_PUT['validated_date'] : $oldComment['validated_date'],
			"archivedDate"  => isset($_PUT['archived_date']) ? $_PUT['archived_date'] : $oldComment['archived_date']
		]);

		$commentId = $commentManager->set($comment);
		echo json_encode($commentId);
		die();
	}

	public function delete($commandId) {
		$commentManager = new CommentManager();
		echo json_encode($commentManager->del($commandId));
		die();
	}

}