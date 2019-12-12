<template>
	<main class="root-container">
		<h2>Un Baume pas comme les autres!</h2>
		<div id="video">
			<div>
				<p>De nos jours, les baumes à lèvres sont devenus <strong>un produit cosmétique nécessaire</strong> pour la plupart des femmes. Cependant, beaucoup des baumes sur le marché contiennent des colorants artificiels, et des produits chimiques tel que la paraffine.</p>
				<p>Sur du long terme, ce type de produits peuvent provoquer, des gerçures, le vieillissement prématuré des lèvres, un empoisonnement au mercure ou au plomb en rendant les lèvres ternes ou décolorées etc...</p>
				<p>L’élément le plus important à prendre en compte lorsque l'on utilise un baume à lèvres est que <strong>les ingrédients doivent être naturels et bons pour la santé</strong>.</p>
				<p>Grâce à ces différents ingrédients actifs naturels, le baume à lèvres Legend Age est <strong>un baume sain</strong> avec un véritable effet de <strong>régénération de la peau</strong> et de <strong>protection</strong> contre les UV et le froid.</p>
			</div>
			<video oncontextmenu="return false;" controls preload="metadata">
				<source src="/assets/videos/video-accueil-desktop.mp4" type="video/mp4" media="all and (min-width: 800px)">
				<source src="/assets/videos/video-accueil-desktop.webm" type="video/webm" media="all and (min-width: 800px)">
				<source src="/assets/videos/video-accueil-mobile.mp4" type="video/mp4" media="all and (max-width: 799px)">
				<source src="/assets/videos/video-accueil-mobile.webm" type="video/webm" media="all and (max-width: 799px)">
				Désolé mais votre navigateur ne supporte pas les vidéos
			</video>
		</div>
		<img src="/assets/images/flyer.png" id="flyer" alt="Avant Après - Legend Age">
		<!-- <picture  id="avant-apres">
			<source srcset="/assets/images/avant_apres_home.jpg" type="image/jpg" media="(min-width: 600px)">
			<img alt="Avant Après - Legend Age" src="/assets/images/avant_apres_home_mobile.jpg">
		</picture> -->
	</main>
</template>

<script src="./Root.js"></script>
<style lang="scss">@import "./Root.scss";</style>