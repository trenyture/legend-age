<template>

	<input
		v-if="type == 'hidden'"
		v-model="model"
		:name="name"
		type="hidden">

	<template v-if="type === 'checkbox' || type === 'radio'">
		<div v-else class="input-form">
			<span class="input-label">{{label}}</span>
			<label
				v-for="(choice, index) in choices"
				:key="name + '-choice-' + index"
				:value="choice.value"
			>
				<input
					v-model="model"
					:multiple="multiple"
					:type="type"
					:name="name"
					:required="required"
					:disabled="disabled"
					:readonly="readonly"
					:value="choice.value"> {{ choice.label || choice.value }}
			</label>

			<!-- AIDE POUR REMPLIR L'INPUT -->
			<small class="input-help" v-if="$slots.default"><slot></slot></small>

			<!-- EN CAS D'ERREUR -->
			<ul class="input-errors" v-if="this.errors && this.errors.length > 0">
				<li v-for="(error, index) in this.errors" :key="'input-error-' + index">
					{{ error }}
				</li>
			</ul>
		</div>
	</template>

	<label v-else class="input-form">
		<span class="input-label">{{label}}</span>
		<select
			v-if="type === 'select'"
			v-model="model"
			:type="type"
			:name="name"
			:required="required"
			:disabled="disabled"
			:readonly="readonly"
			:multiple="multiple"
			:value="value"
		>
			<option
				v-for="(choice, index) in choices"
				:key="name + '-choice-' + index"
				:value="choice.value"
			>{{ choice.label || choice.value }}</option>
		</select>
		<input
			v-else
			v-model="model"
			:type="type"
			:name="name"
			:required="required"
			:disabled="disabled"
			:readonly="readonly"
			:multiple="multiple"
			:min="min"
			:max="max"
			:step="step"
			:value="value"
			:placeholder="placeholder"
		>

		<!-- AIDE POUR REMPLIR L'INPUT -->
		<small class="input-help" v-if="$slots.default">
			<slot></slot>
		</small>

		<!-- EN CAS D'ERREUR -->
		<ul class="input-errors" v-if="this.errors && this.errors.length > 0">
			<li v-for="(error, index) in this.errors" :key="'input-error-' + index">
				{{ error }}
			</li>
		</ul>
	</label>
</template>

<style lang="scss">@import "./Input.scss";</style>
<script src="./Input.js"></script>
