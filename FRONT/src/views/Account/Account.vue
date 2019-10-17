<template>
	<main class="account-container">
		<Login v-if="!isLogged"  />
	</main>
</template>

<style lang="scss">@import "./Account.scss";</style>
<script src="./Account.js"></script>