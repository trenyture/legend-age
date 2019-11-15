<template>
	<header id="app-header">
		<nav id="mobile">
			<router-link :to="{name: 'root'}">
				<h1>Legend Age - Un baume mille couleurs</h1>
			</router-link>
			<a id="burger" @click="$event.stopImmediatePropagation(); $event.preventDefault(); actived = !actived; return false;">☰</a>
			<transition name="toggle-menu">
				<ul v-if="actived" :class="{'main-menu': true}">
					<li>
						<router-link :to="{name: 'product'}">Produit</router-link>
					</li>
					<li>
						<router-link :to="{name: 'basket'}">Panier</router-link>
					</li>
					<li>
						<router-link :to="{name: 'contact'}">Contact</router-link>
					</li>
					<li v-if="false">
						<router-link :to="{name: 'account'}">Mon compte</router-link>
					</li>
					<li>
						<router-link :to="{name: 'cgv'}">CGV</router-link>
					</li>
				</ul>
			</transition>
		</nav>
		<nav id="desktop">
			<ul>
				<li>
					<router-link :to="{name: 'product'}">Produit</router-link>
				</li>
				<li>
					<router-link :to="{name: 'basket'}">Panier</router-link>
				</li>
				<li class="logo-item">
					<router-link :to="{name: 'root'}">
						<h1>Legend Age - Un baume mille couleurs</h1>
					</router-link>
				</li>
				<li>
					<router-link :to="{name: 'contact'}">Contact</router-link>
				</li>
				<li v-if="false">
					<router-link :to="{name: 'account'}">Mon compte</router-link>
				</li>
				<li>
					<router-link :to="{name: 'cgv'}">CGV</router-link>
				</li>
			</ul>
		</nav>
	</header>
</template>

<script src="./Header.js"></script>
<style lang="scss">@import "./Header.scss";</style>