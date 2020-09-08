import { mapGetters } from "vuex";

import Form from "@/components/Form/Form.vue";
import Input from "@/components/Input/Input.vue";
import Button from "@/components/Button/Button.vue";

export default {
	components: {Form, Input, Button},
	data() {
		return {
			now: new Date(),
			isBlackFriday: false,
		};
	},
	computed: {
		...mapGetters({
			basketLines: 'getBasket',
		}),
		totalPrice() {
			let tt = this.basketLines.reduce((r,e) => {
				return r + e.quantity * (e.byFour == true ? 35 : (29 - (this.isPromo || 0)));
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
		goWithStripe() {
			let form = new FormData();
			for(var i = 0, len = this.basketLines.length; i < len; i++) {
				form.append('ordered_quantity[]', this.basketLines[i].quantity);
				form.append('fk_product[]', this.basketLines[i].byFour ? 2 : 1);
			}

			this.$ajax({
				url: '/payment',
				method: 'POST',
				data: form,
				success: r => {
					Stripe(this.stripePublicKey).redirectToCheckout({
						sessionId: r.stripe_id,
					});
				},
			});
		},
	},
	beforeMount() {
		if(this.now >= new Date('2020-01-08 00:00:00') && this.now < new Date('2020-02-02 00:00:00')) {
			this.isBlackFriday = true;
			this.isPromo = 9.01;
		}
	},
	mounted() {
		if(this.$refs.paypalButtons) {
			paypal.Buttons({
				createOrder: (data, actions) => {
					return actions.order.create({
						purchase_units: [{
							amount: {
								value: this.totalPrice.toFixed(2),
								currency_code: 'EUR'
							}
						}]
					});
				},
				onApprove: (data, actions) => {
					return actions.order.capture().then((details) => {
						this.$router.push({name: "confirmed", params: { type: "paypal", orderId: data.orderID }});
					});
				},
			}).render('#paypal-buttons');
		}
	},
	updated() {
		if(this.now >= new Date('2020-01-08 00:00:00') && this.now < new Date('2020-02-02 00:00:00')) {
			this.isBlackFriday = true;
			this.isPromo = 9.01;
		}
	}

}