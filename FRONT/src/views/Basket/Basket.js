import { mapGetters } from "vuex";

import Button from "@/components/Button/Button.vue";

export default {
	components: {},
	data() {
		return {

		};
	},
	computed: {
		...mapGetters({
			basketLines: 'getBasket',
		}),
		tvaPrice() {
			return this.basketLines.reduce((r,e) => {
				return r + e.quantity * (0.2 * (e.byFour == true ? 99 : 29.90));
			}, 0);
		},
		totalPrice() {
			return this.basketLines.reduce((r,e) => {
				return r + e.quantity * (e.byFour == true ? 99 : 29.90);
			}, 0);
		},
	},
	watch: {
	},
	methods: {
		order() {
			window.fbq('track', 'InitiateCheckout');
			this.$router.push({name: 'order'});
		}
	},
};