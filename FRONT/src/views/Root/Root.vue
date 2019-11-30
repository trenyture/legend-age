<template>
	<main class="root-container">
		<div class="logos">
			<img src="/assets/images/logo-or.png" alt="Logo - Legend Age">
			<img src="/assets/images/legendage-or.png" alt="Titre -  Legend Age">
		</div>
		<picture id="avant-apres">
			<source srcset="/assets/images/avant_apres_home.jpg" type="image/jpg" media="(min-width: 600px)">
			<img alt="Avant Après - Legend Age" src="/assets/images/avant_apres_home_mobile.jpg">
		</picture>
		<section class="product">
			<h2>Un Baume pas comme les autres!</h2>
			<img src="/assets/images/beaume.png" alt="Beaume - Soin des lèvres">
			<p>De nos jours, les baumes à lèvres sont devenus un produit cosmétique nécessaire pour la plupart des femmes. Cependant, beaucoup des baumes sur le marché contiennent des colorants artificiels, et des produits chimiques tel que la paraffine.</p>
			<p>Sur du long terme, ce type de produits peuvent provoquer, des gerçures, le vieillissement prématuré des lèvres, un empoisonnement au mercure ou au plomb en rendant les lèvres ternes ou décolorées etc...</p>
			<p>L’élément le plus important à prendre en compte lorsque l'on utilise un baume à lèvres est que les ingrédients doivent être naturels et bons pour la santé.</p>
			<p>Grâce à ces différents ingrédients actifs naturels, le baume à lèvres Legend Age est un baume sain avec un véritable effet de régénération de la peau et de protection contre les UV et le froid.</p>
		</section>
		<video id="video" oncontextmenu="return false;" controls preload="metadata">
			<source src="/assets/videos/video-accueil-desktop.mp4" type="video/mp4" media="all and (min-width: 800px)">
			<source src="/assets/videos/video-accueil-desktop.webm" type="video/webm" media="all and (min-width: 800px)">
			<source src="/assets/videos/video-accueil-mobile.mp4" type="video/mp4" media="all and (max-width: 799px)">
			<source src="/assets/videos/video-accueil-mobile.webm" type="video/webm" media="all and (max-width: 799px)">
			Désolé mais votre navigateur ne supporte pas les vidéos
		</video>
	</main>
</template>

<script src="./Root.js"></script>
<style lang="scss">@import "./Root.scss";</style>