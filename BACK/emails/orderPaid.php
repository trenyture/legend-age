<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Nouvelle commande sur Soins des Lèvres</title>
	</head>
	<body>
		<p>Cher <?php echo $datas['recipient'] ?>,</p>
		<p>Vous venez de réaliser une commande sur <a href="https://www.soins-des-levres.fr">www.soins-des-levres.fr</a> pour un total de <?php echo number_format($datas['total_price_with_tax'], 2, ',', ' ') ?> € TTC et nous vous en remercions.</p>
		<?php if (isset($datas['commandLines']) && count($datas['commandLines']) > 0): ?>
			<p>Récapitulatif : </p>
			<table>
				<thead>
					<tr>
						<td>Produit</td>
						<td>Prix unitaire HT</td>
						<td>Prix total HT</td>
						<td>Prix total TTC</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($datas['commandLines'] as $cmdLine): ?>
						<?php $price = $cmdLine["fk_product"] == 2 ? 99 : 29; ?> 
						<tr>
							<td>
								<?php
									$s = $cmdLine["ordered_quantity"] > 1 ? 's' : '';
									echo $cmdLine["ordered_quantity"] . " x ";
									if ($cmdLine["fk_product"] == 2){
										echo "lot".$s." de 4 exemplaires";
									}
									else {
										echo "exemplaire".$s;
									}
								?> de Legend Age - Soin des lèvres
							</td>
							<td><?php echo number_format(($price / 1.2), 2, ',', ' '); ?> €</td>
							<td><?php echo number_format(($cmdLine["ordered_quantity"] * ($price / 1.2)), 2, ',', ' '); ?> €</td>
							<td><?php echo number_format(($cmdLine["ordered_quantity"] * $price), 2, ',', ' '); ?> €</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		<?php endif ?>
		<p>Nous allons traiter votre commande dans les plus brefs délais.</p>
		<p>À très bientôt.</p>
		<p></p>
		<p><small>Message automatique envoyé depuis le site web</small></p>
	</body>
</html>