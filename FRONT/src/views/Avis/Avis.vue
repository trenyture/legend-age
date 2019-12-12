<template>
	<main class="notation-container">
		<h2>Votre avis compte</h2>
		<p>Vous avez récemment réalisé une commande sur notre site et votre avis est très important pour nous. Avec le formulaire suivant vous pourrez laisser une qualification publique sur le produit.</p>
		<Form
			action="/comment"
			method="POST"
			@formSent="formSent"
		>
			<Notation
				:notation="note"
				@clicked="note = $event"
			/>
			<Input
				type="hidden"
				name="notation"
				label="Note"
				:value="note"
			/>
			<Input
				type="textarea"
				name="message"
				label="Votre commentaire"
			/>
			<div class="two-cols">
				<Input
					type="text"
					name="firstname"
					label="Votre Prénom"
				/>
				<Input
					type="text"
					name="lastname"
					label="Votre Nom"
				/>
			</div>
			<div class="buttons">
				<router-link
					:to="{name: 'root'}"
					class="button button-outline-gray"
				>Accueil</router-link>
				<Button
					type="submit"
					class="button-orange"
				>Envoyer</Button>
			</div>
		</Form>
	</main>
</template>

<style lang="scss">@import "./Avis.scss";</style>
<script src="./Avis.js"></script>