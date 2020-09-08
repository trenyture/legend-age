<?php
	require_once(dirname(__FILE__) . '/_head.php');
?>

	<p>Bonjour <?php echo $datas['recipient'] ?>,</p>
	<p>Nous vous remercions pour votre commande sur <a href="https://www.soins-des-levres.fr">www.soins-des-levres.fr</a> pour un total de <?php echo number_format($datas['total_price_with_tax'], 2, ',', ' ') ?> € TTC. Nous l'avons bien prise en compte et allons vous envoyer le plus rapidement possible vos articles.</p>
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
					<?php
						$price = $cmdLine["fk_product"] == 2 ? 35 : (!is_null(PROMO) ? 29 - PROMO : 29);
					?> 
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
				<?php if (ISBLACKFRIDAY): ?>
					<tr>
						<td>Envoi suivi sous papier bulle</td>
						<td><?php echo number_format((2.50 / 1.2), 2, ',', ' ') ?> €</td>
						<td><?php echo number_format((2.50 / 1.2), 2, ',', ' ') ?> €</td>
						<td>2,16 €</td>
					</tr>
				<?php endif ?>
			</tbody>
		</table>
	<?php endif ?>
	<p>Encore merci et à très bientôt sur <a href="https://www.soins-des-levres.fr">www.soins-des-levres.fr</a></p>

<?php
	require_once(dirname(__FILE__) . '/_foot.php');
?>