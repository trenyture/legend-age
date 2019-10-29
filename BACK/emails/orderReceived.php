<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Nouvelle commande sur Soins Des Lèvres</title>
	</head>
	<body>
		<p>Bonjour,</p>
		<p><?php echo $datas['recipient'] ?> vient de commander sur <a href="https://www.soins-des-levres.fr">www.soins-des-levres.fr</a> pour un total de <?php echo number_format($datas['total_price_with_tax'], 2, ',', ' ') ?> € TTC</p>
		<p>
			L'adresse de livraison est : 
			<br><?php echo $datas['recipient']; ?>
			<br><?php echo $datas['street']; ?>
			<?php if (!is_null($datas['complement'])): ?>
				<br><?php echo $datas['complement']; ?>
			<?php endif ?>
			<br><?php echo $datas['postcode']; ?> <?php echo $datas['city']; ?> 
			<br><?php echo $datas['country']; ?>
			<br><br>Tel : <?php echo $datas['phone_number']; ?>
			<br>Maill : <?php echo $datas['email']; ?>
		</p>
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
						<?php $price = $cmdLine["fk_product"] == 2 ? 99 : 29.90; ?> 
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
		<p></p>
		<p><small>Message automatique envoyé depuis le site web</small></p>
	</body>
</html>