<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Nouvelle demande de contact</title>
	</head>
	<body>
		<p>Vous avez reçu une nouvelle demande de contact de la part de <?php echo $datas['name'] ?> :</p>
		<p><?php echo nl2br($datas['message']); ?></p>
		<p><small>Message automatique envoyé depuis le site web</small></p>
	</body>
</html>