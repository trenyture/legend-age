<template>
	<button
		class="button"
		:type="type"
		@click="$emit('click', $event)"
	><slot></slot></button>
</template>

<style lang="scss">@import "./Button.scss"</style>

<script src="./Button.js"></script>