<template>
	<div id="app" :class="$router.currentRoute.name + '-page'" >
		<div id="bandeau-promo" v-if="!isBlackFriday && ['root', 'product'].includes($route.name)">
			<img src="/assets/images/bandeau-promo.png" @click="buyPromo">
		</div>
		<Header />
		<Bandeau v-if="$router.currentRoute.name === 'root'" />
		<router-view id="app-content" />
		<Footer/>
	</div>
</template>

<style lang="scss">@import "./App.scss"</style>
<script src="./App.js"></script>
