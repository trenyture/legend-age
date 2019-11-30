<template>
	<main class="contact-container">
		<h2>Contact</h2>
		<p class="explication">Vous avez <span>une question</span> ou peut être <span>une remarque</span> ? N'hésitez pas à nous envoyer un message avec le formulaire suivant, nous y répondrons dans les plus brefs délais.</p>
		<Form
			action="/contact"
			method="POST"
			:disabled="disabled"
			@formSent="formSent"
		>
			<Input
				label="Votre nom"
				name="name"
				type="text"
			/>
			<Input
				label="Votre email"
				name="email"
				type="email"
			/>
			<Input
				label="Sujet du message"
				name="subject"
				type="text"
			/>
			<Input
				label="Votre message"
				name="message"
				type="textarea"
			/>
			<div class="buttons">
				<Button
					type="submit"
					class="button-outline-orange"
				>Envoyer</Button>
			</div>
		</Form>
	</main>
</template>

<style lang="scss">@import "./Contact.scss";</style>
<script src="./Contact.js"></script>