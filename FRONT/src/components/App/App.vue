<template>
	<div id="app" :class="$router.currentRoute.name + '-page'" >
		<Bandeau v-if="$router.currentRoute.name === 'root'" />
		<Header />
		<router-view id="app-content" />
		<Footer/>
	</div>
</template>

<style lang="scss">@import "./App.scss"</style>
<script src="./App.js"></script>
