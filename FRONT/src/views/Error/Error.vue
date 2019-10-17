<template>
	<main class="error-container">
		<h2>Petit problème</h2>
		<p>Cette page est introuvable, n'hésitez pas à revenir vers la <router-link :to="{name: 'root'}">page d'accueil</router-link></p>
	</main>
</template>

<script src="./Error.js"></script>
<style lang="scss">@import "./Error.scss";</style>