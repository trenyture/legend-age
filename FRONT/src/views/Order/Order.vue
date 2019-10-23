<template>
	<main class="order-container" v-if="isReady">
		<h2>Paiement</h2>
		<p>Veuillez renseigner ces informations afin de terminer votre commande d'un montant de <strong>{{ totalPrice.toFixed(2) }} €</strong> TTC</p>
		<Form
			:disabled="disableForm"
			:preventSend="true"
			@formSent="formSent"
		>
			<Input
				name="recipient"
				type="text"
				label="Nom et Prénom"
			/>
			<Input
				name="email"
				type="email"
				label="Votre email"
			/>
			<Input
				name="phone_number"
				type="text"
				label="Numéro de Téléphone"
			/>
			<Input
				name="street"
				type="text"
				label="Adresse"
			/>
			<Input
				name="complement"
				type="text"
				label="Complément d'adresse"
				:required="false"
			/>
			<div class="city">
				<Input
					name="postcode"
					type="text"
					label="Code Postal"
					:min="4"
					@change="loadCities"
				/>
				<Input
					name="city"
					type="select"
					label="Ville"
					:disabled="cities === null || cities.length === 0"
					:choices="cities != null ? cities.map(e=>{
						return {
							label: e.nom,
							value: e.nom,
						}
					}) : []"
				/>
			</div>
			<Input
				name="fk_country"
				type="select"
				label="Pays"
				:choices="countries.map(e => {
					return {value: e.id, label: e.label};
				})"
				:value="77"
			/>
			<Input
				name="delivery_instructions"
				type="textarea"
				label="Commentaire"
				:required="false"
			/>
			<div class="buttons">
				<router-link class="button button-outline-gray" :to="{name: 'basket'}">Retour</router-link>
				<Button
					type="submit"
					class="button-orange"
				>Payer</Button>
			</div>
		</Form>
	</main>
</template>

<style lang="scss">@import "./Order.scss";</style>
<script src="./Order.js"></script>