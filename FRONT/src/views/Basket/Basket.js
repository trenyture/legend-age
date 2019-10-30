import { mapGetters } from "vuex";

import Button from "@/components/Button/Button.vue";
import Input from "@/components/Input/Input.vue";

export default {
	components: {Input, Button},
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
				return r + e.quantity * (0.2 * (e.byFour == true ? 99 : 29));
			}, 0);
		},
		totalPrice() {
			return this.basketLines.reduce((r,e) => {
				return r + e.quantity * (e.byFour == true ? 99 : 29);
			}, 0);
		},
	},
	watch: {
	},
	methods: {
		order() {
			if(!this.$refs.checkbox.model[0] || this.$refs.checkbox.model[0] != 1){
				return this.$alert.swal({
					type: "error",
					title: "Attention",
					message: "Vous devez accepter les conditions générales avant de continuer",
					timer: 2000,
				});
			}
			window.fbq('track', 'InitiateCheckout');
			this.$router.push({name: 'order'});
		}
	},
};