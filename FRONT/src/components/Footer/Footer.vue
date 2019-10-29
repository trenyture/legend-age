<template>
	<footer id="app-footer">
		<ul>
			<li>
				<router-link :to="{name: 'cgv'}">Conditions générales de ventes</router-link>
			</li>
		</ul>
		<p>Site réalisé par <a href="https://simon-tr.com" target="_blank">Simon Trichereau</a></p>
	</footer>
</template>

<script src="./Footer.js"></script>
<style lang="scss">@import "./Footer.scss";</style>