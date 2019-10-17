<template>
	<header id="app-header">
		<nav>
			<ul>
				<li>
					<router-link :to="{name: 'product'}">Produit</router-link>
				</li>
				<li>
					<router-link :to="{name: 'basket'}">Panier</router-link>
				</li>
				<li>
					<router-link :to="{name: 'root'}">
						<h1>Legend Age - Un baume mille couleurs</h1>
					</router-link>
				</li>
				<li>
					<router-link :to="{name: 'contact'}">Contact</router-link>
				</li>
				<li>
					<router-link :to="{name: 'account'}">Mon compte</router-link>
				</li>
			</ul>
		</nav>
	</header>
</template>

<script src="./Header.js"></script>
<style lang="scss">@import "./Header.scss";</style>