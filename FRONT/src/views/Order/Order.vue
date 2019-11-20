<template>
	<main class="order-container">
		<h2>Paiement</h2>
		<p>Choisissez une méthode de paiement pour terminer votre commande d'un montant total de <strong>{{ totalPrice.toFixed(2) }} €</strong> TTC</p>
		<div id="paypal-buttons" ref="paypalButtons"></div>
		<span class="or">ou</span>
		<Button id="stripe-button" class="button button-orange" @click="goWithStripe"><i class="lnr-lock"></i> Stripe</Button>
		<p class="center"><small>Attention, vous serez redirigez vers le site en question afin d'effectuer le paiement</small></p>
	</main>
</template>

<style lang="scss">@import "./Order.scss";</style>
<script src="./Order.js"></script>