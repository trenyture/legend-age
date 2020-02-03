import { mapGetters } from "vuex";

import Button from "@/components/Button/Button.vue";
import Input from "@/components/Input/Input.vue";

export default {
	components: {Input, Button},
	data() {
		return {
			now : new Date(),
			isBlackFriday: false,
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
		promoPrice() {
			return this.basketLines.reduce((r,e) => {
				return r + e.quantity * (e.byFour == true ? 0 : this.isPromo);
			}, 0);
		},
		totalPrice() {
			let tt = this.basketLines.reduce((r,e) => {
				return r + e.quantity * (e.byFour == true ? 99 : (this.isPromo ? 29 - this.isPromo : 29));
			}, 0);
			if(this.isBlackFriday) {
				tt += 2.5;
			}
			return tt;
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
		},
	},
	beforeMount() {
		if(this.now >= new Date('2020-01-08 00:00:00') && this.now < new Date('2020-02-02 00:00:00')) {
			this.isBlackFriday = true;
			this.isPromo = 9.01;
		}
	},
	updated() {
		if(this.now >= new Date('2020-01-08 00:00:00') && this.now < new Date('2020-02-02 00:00:00')) {
			this.isBlackFriday = true;
			this.isPromo = 9.01;
		}
	}
};