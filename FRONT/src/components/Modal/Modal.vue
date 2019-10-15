<template>
	<div class="modal" :class="{ 'actived' : opened }" @click.self="closingModal">
		<div class="modal-content">
			<slot></slot>
		</div>
	</div>
</template>

<script src="./Modal.js"></script>
<style lang="scss">@import "./Modal.scss";</style>