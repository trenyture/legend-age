<template>
	<main class="basket-container">
		<h2>Mon panier</h2>
		<table>
			<thead>
				<tr>
					<th>Quantité</th>
					<th>Produit</th>
					<th>Prix unitaire HT</th>
					<th>Prix total HT</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td>Lot de 4exemplaires</td>
					<td>82,50 €</td>
					<td>82,50 €</td>
				</tr>
				<tr>
					<td>2</td>
					<td>Unités</td>
					<td>29,90 €</td>
					<td>59,80 €</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td></td>
					<td></td>
					<td>TVA (20%)</td>
					<td>28,46 €</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>TOTAL TTC</td>
					<td>170,76 €</td>
				</tr>
			</tfoot>
		</table>
	</main>
</template>

<script src="./Basket.js"></script>
<style lang="scss">@import "./Basket.scss";</style>