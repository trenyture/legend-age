<?php

class CommentController {

	public function retrieve($commentId = null) {
		$commentManager = new CommentManager();

		$validated = isset($_GET['validated']) ? $_GET['validated'] : true;
		$archived = isset($_GET['archived'])   ? $_GET['archived'] : false;

		echo json_encode($commentManager->get($commentId, $validated, $archived));
		die();
	}

	public function insert() {

		$commentManager = new CommentManager();

		$comment = new Comment([
			"id"            => $_POST['id'],
			"firstname"     => $_POST['firstname'],
			"lastname"      => $_POST['lastname'],
			"message"       => $_POST['message'],
			"createdDate"   => $_POST['created_date'],
			"validatedDate" => $_POST['validated_date'],
			"archivedDate"  => $_POST['archived_date']
		]);

		$commentId = $commentManager->set($comment);
		echo json_encode($commentId);
		die();
	}

	public function update($commandId) {
		/* Les données PUT arrivent du flux */
		$_PUT = parse_str(file_get_contents("php://input"));
		echo json_encode($_PUT);
		die();
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
			"firstname"     => isset($_POST['firstname']) ? $_POST['firstname'] : $oldComment['firstname'],
			"lastname"      => isset($_POST['lastname']) ? $_POST['lastname'] : $oldComment['lastname'],
			"message"       => isset($_POST['message']) ? $_POST['message'] : $oldComment['message'],
			"createdDate"   => $oldComment['created_date'],
			"validatedDate" => isset($_POST['validated_date']) ? $_POST['validated_date'] : $oldComment['validated_date'],
			"archivedDate"  => isset($_POST['archived_date']) ? $_POST['archived_date'] : $oldComment['archived_date']
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