<template>
	<form @submit="submit" novalidate="false">
		<fieldset :disabled="isDisabled">
			<slot></slot>
		</fieldset>
	</form>
</template>

<script src="./Form.js"></script>
<style lang="scss"> @import "./Form.scss"; </style>