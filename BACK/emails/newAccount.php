<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Nouveau Compte</title>
	</head>
	<body>
		<p>Bonjour <?php echo $datas['firstname'] ?> <?php echo $datas['lastname'] ?>,</p>
		<p>Vous venez de créer un compte sur <a href="https://www.soins-des-levres.fr" target="_blank">www.soins-des-levres.fr</a>, afin de finaliser votre inscription et renseigner un mot de passe, nous vous prions de cliquer <a href="https://www.soins-des-levres.fr/account/<?php echo $datas['activation-key'] ?>" target="_blank"></a>ici.</p>
		<p><small>Si jamais le click ne fonctionne pas, vous pouvez copier/coller le lien suivant dans votre navigateur : https://www.soins-des-levres.fr/account/<?php echo $datas['activation-key'] ?></small></p>
		<p>À bientôt sur Soins Des Lèvres</p>
	</body>
</html>