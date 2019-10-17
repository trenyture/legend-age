<template>
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
		/>
		<Input
			type="password"
			label="Votre mot de passe"
			name="password"
		>Mot de passe perdu</Input>
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
			label="Votre Prénom"
			name="firstname"
		/>
		<Input
			type="text"
			label="Votre Nom"
			name="lastame"
		/>
		<Input
			type="email"
			label="Votre email"
			name="email"
		/>
		<Input
			type="date"
			label="Votre date de naissance"
			name="birth-date"
		/>
		<Input
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
		</Input>
		<div class="buttons">
			<Button
				type="submit"
				class="button-outline-orange"
			>Inscription</Button>
		</div>
	</Form>
</template>

<style lang="scss">@import "./Login.scss"</style>
<script src="./Login.js"></script>