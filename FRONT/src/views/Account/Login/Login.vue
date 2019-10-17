<template>
	<div class="login">
		<Form
			id="login"
			action="/authenticate"
			method="POST"
		>
			<h2>Vous avez déjà un compte ?</h2>
			<Input
				type="email"
				label="Votre email"
				name="email"
				@change="email = $event"
			/>
			<Input
				type="password"
				label="Votre mot de passe"
				name="password"
			>
				<a @click.prevent="modalOpened = true" href="#">Mot de passe perdu</a>
			</Input>
			<div class="buttons">
				<Button
					type="submit"
					class="button-orange"
				>Connexion</Button>
			</div>
		</Form>

		<Form
			id="new-user"
			action="/user"
			method="POST"
			:preventSend="strongPassword != true || samePasswords != true"
		>
			<h2>Vous souhaitez créer gratuitement un compte ?</h2>
			<Input
				type="text"
				label="Votre nom"
				name="lastame"
			/>
			<Input
				type="text"
				label="Votre prénom"
				name="firstname"
			/>
			<Input
				type="email"
				label="Votre email"
				name="email"
				@change="email = $event"
			/>
			<Input
				type="date"
				label="Votre date de naissance"
				name="birth-date"
			/>
			<!-- <Input
				type="password"
				label="Votre mot de passe"
				name="password"
				:value="pass"
				@change="pass = $event"
			>
				<template v-if="!strongPassword">Le mot de passe doit faire minimum 6 caractères, contenir au moins une majuscule, une minuscule et un nombre</template>
			</Input>
			<Input
				type="password"
				label="Confirmation du mot de passe"
				name="password-verification"
				:value="passCheck"
				@change="passCheck = $event"
			>
				<template v-if="!samePasswords">Les mots de passe ne correspondent pas</template>
			</Input> -->
			<div class="buttons">
				<Button
					type="submit"
					class="button-outline-orange"
				>Inscription</Button>
			</div>
		</Form>

		<Modal
			id="forgotten-password-modal"
			:opened.sync="modalOpened"
		>
			<Form
				action="/authenticate"
				method="PUT"
				@formSent="modalOpened = false"
			>
				<h2>Mot de passe perdu</h2>
				<p>Renseignez votre email ci-dessous afin que nous vous envoyions un email de réinitialisation de mot de passe</p>
				<Input
					type="email"
					name="email"
					label="Votre email"
					:value="email"
				></Input>
				<div class="buttons">
					<Button
						class="button-outline-gray"
						@click="modalOpened = false"
					>Annuler</Button>
					<Button
						type="submit"
						class="button-orange"
					>Envoyer</Button>
				</div>
			</Form>
		</Modal>
	</div>
</template>

<style lang="scss">@import "./Login.scss"</style>
<script src="./Login.js"></script>