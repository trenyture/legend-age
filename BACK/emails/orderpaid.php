<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Nouvelle demande de contact</title>
	</head>
	<body>
		<p>Cher <?php echo $datas['recipient'] ?>,</p>
		<p>Vous venez de réaliser une commande sur <a href="https://www.soins-des-levres.fr">www.soins-des-levres.fr</a> pour un total de <?php echo number_format($datas['totalPriceWithTax'], 2, ',', ' ') ?> € TTC et nous vous en remercions.</p>
		<p>Nous allons traiter votre commande dans les plus brefs délais.</p>
		<p>À très bientôt.</p>
		<p></p>
		<p><small>Message automatique envoyé depuis le site web</small></p>
	</body>
</html>