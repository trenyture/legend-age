<template>
	<div id="app">
		<Bandeau v-if="$router.currentRoute.name === 'root'" />
		<Header :class="{'home-page' : $router.currentRoute.name === 'root'}" />
		<router-view id="app-content" />
		<Footer/>
	</div>
</template>

<style lang="scss">@import "./App.scss"</style>
<script src="./App.js"></script>
