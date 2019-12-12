<template>
	<div class="notation">
		<ul class="background">
			<li v-for="n in 5" :key="`star-${n}`" @click="$emit('clicked', n)"></li>
		</ul>
		<ul class="front" :style="`width: ${notation*20}%`">
			<li v-for="n in 5" :key="`sub-star-${n}`" @click="$emit('clicked', n)"></li>
		</ul>
	</div>
</template>

<style lang="scss">@import "./Notation.scss";</style>
<script src="./Notation.js"></script>