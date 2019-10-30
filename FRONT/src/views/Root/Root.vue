<template>
	<main class="root-container">
		<video id="video" oncontextmenu="return false;" controls preload="metadata">
			<source src="/assets/videos/video-accueil-desktop.mp4" type="video/mp4" media="all and (min-width: 800px)">
			<source src="/assets/videos/video-accueil-desktop.webm" type="video/webm" media="all and (min-width: 800px)">
			<source src="/assets/videos/video-accueil-mobile.mp4" type="video/mp4" media="all and (max-width: 799px)">
			<source src="/assets/videos/video-accueil-mobile.webm" type="video/webm" media="all and (max-width: 799px)">
			Désolé mais votre navigateur ne supporte pas les vidéos
		</video>
		<section class="product">
			<h2>Le produit</h2>
			<img src="/assets/images/beaume.png" alt="Beaume - Soin des lèvres">
			<p>De nos jours, les baumes à lèvres sont devenus un produit cosmétique nécessaire pour la plupart des femmes. Cependant, beaucoup des baumes sur le marché contiennent des colorants artificiels, et des produits chimiques tel que la paraffine.</p>
			<p>Sur du long terme, ce type de produits peuvent provoquer, des gerçures, le vieillissement prématuré des lèvres, un empoisonnement au mercure ou au plomb, rendre les lèvres ternes ou les décolorées etc...</p>
			<p>L’élément le plus important à prendre en compte lorsque l'on utilise un baume à lèvres est que les ingrédients doivent être naturels et bons pour la santé.</p>
			<p>Grâce à ces différents ingrédients actifs naturels, le baume à lèvres Legend Age est un baume sain avec un véritable de effet de régénération de la peau et de protection contre les UV.</p>
			<p>C’est un produit cosmétique pour les lèvres qui a reçu diverses récompenses de l’industrie de la beauté, de la mode ainsi que par les administrations gouvernementales des pays ou il est commercialisé.</p>
		</section>
	</main>
</template>

<script src="./Root.js"></script>
<style lang="scss">@import "./Root.scss";</style>