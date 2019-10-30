<template>
	<div id="app" :class="$router.currentRoute.name + '-page'" >
		<Header />
		<Bandeau v-if="$router.currentRoute.name === 'root'" />
		<router-view id="app-content" />
		<Footer/>
	</div>
</template>

<style lang="scss">@import "./App.scss"</style>
<script src="./App.js"></script>
