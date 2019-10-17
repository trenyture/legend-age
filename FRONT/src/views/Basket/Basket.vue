<template>
	<main class="basket-container">
		<h2>Récapitulatif de votre commande</h2>
		<template v-if="basketLines && basketLines.length > 0">
			<table>
				<thead>
					<tr>
						<th></th>
						<th>Quantité</th>
						<th>Prix unitaire HT</th>
						<th>Prix total HT</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(line, index) in basketLines">
						<td>
							<img alt="Produit - Legend Age" src="/assets/images/product.png">
							<span>Legend Age - Soin des lèvres</span>			
						</td>
						<td>{{ line.quantity }} {{ line.byFour ? `lot${line.quantity > 1 ? 's' : ''} de 4 exemplaires` : `exemplaire${line.quantity > 1 ? 's' : ''}` }}</td>
						<td>{{ parseFloat((line.byFour ? 99 : 29.90)/1.2).toFixed(2) }} €</td>
						<td>{{ parseFloat((line.quantity * (line.byFour ? 99 : 29.90) / 1.2)).toFixed(2) }} €</td>
						<td>
							<button @click="$store.dispatch('deleteBasketLine', index)">‎✕</button>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="impots">
				<tbody>
					<tr>
						<td>TVA (20%)</td>
						<td>{{ tvaPrice.toFixed(2) }} €</td>
					</tr>
					<tr>
						<td>Livraison</td>
						<td>Offerte !</td>
					</tr>
					<tr>
						<td>Total TTC</td>
						<td>{{ totalPrice.toFixed(2) }} €</td>
					</tr>
				</tbody>
			</table>
			<div class="buttons">
				<router-link :class="'button button-outline-orange'" :to="{name: 'order'}">Commander</router-link>
			</div>
		</template>
		<p v-else>Votre panier est vide, n'hésiter pas à faire une commande.</p>
	</main>
</template>

<script src="./Basket.js"></script>
<style lang="scss">@import "./Basket.scss";</style>