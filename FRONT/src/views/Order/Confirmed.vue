<template>
	<main class="order-confirmed-container">
		<h2>Merci</h2>
		<svg id="check" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
			<circle style="fill:#25AE88;" cx="25" cy="25" r="25"/>
			<polyline style="fill:none;stroke:#FFFFFF;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" points="38,15 22,33 12,25 "/>
		</svg>
		<h3>Votre commande est enregistrée</h3>
		<p>Vous recevrez bientôt un email récapitulatif concernant votre commande pour un montant total de <strong>{{ totalPrice.toFixed(2) }} €</strong> <small>TTC</small></p>
	</main>
</template>

<style lang="scss">@import "./Confirmed.scss";</style>
<script src="./Confirmed.js"></script>