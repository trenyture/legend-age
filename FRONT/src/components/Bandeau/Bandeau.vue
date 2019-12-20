<template>
	<div id="bandeau-home">
		<video ref="video" poster="/assets/images/poster-video.png" oncontextmenu="return false;" controls preload="metadata">
			<source src="/assets/videos/video-accueil-desktop.mp4" type="video/mp4" media="all and (min-width: 800px)">
			<source src="/assets/videos/video-accueil-desktop.webm" type="video/webm" media="all and (min-width: 800px)">
			<source src="/assets/videos/video-accueil-mobile.mp4" type="video/mp4" media="all and (max-width: 799px)">
			<source src="/assets/videos/video-accueil-mobile.webm" type="video/webm" media="all and (max-width: 799px)">
			Désolé mais votre navigateur ne supporte pas les vidéos
		</video>
		<img src="/assets/images/bandeau.jpg" alt="Legend Age - Un baume mille couleurs">
		<a href="#" class="scroll" @click.prevent="scrollToVideo">
			<span>⌄</span>
		</a>
	</div>
</template>

<script src="./Bandeau.js"></script>
<style lang="scss">@import "./Bandeau.scss";</style>