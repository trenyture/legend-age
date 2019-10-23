import { mapGetters } from "vuex";

import Form from "@/components/Form/Form.vue";
import Input from "@/components/Input/Input.vue";
import Button from "@/components/Button/Button.vue";

export default {
	components: {Form, Input, Button},
	data() {
		return {
			countries: null,
			cities: [],
			disableForm: false,
		};
	},
	computed: {
		isReady() {
			return this.countries !== null;
		},
		...mapGetters({
			basketLines: 'getBasket',
		}),
		totalPrice() {
			return this.basketLines.reduce((r,e) => {
				return r + e.quantity * (e.byFour == true ? 99 : 29.90);
			}, 0);
		},
	},
	watch: {
		isReady: {
			immediate:true,
			handler(n, o) {
				if(typeof o === "undefined") {
					this.loadCountries();
				}
			}
		}
	},
	methods: {
		loadCountries() {
			this.$ajax({
				url: '/country',
				success: r => this.countries = r,
			});
		},
		loadCities(event){
			this.cities = null;
			fetch('https://geo.api.gouv.fr/communes?codePostal='+event+'&fields=nom,code,codesPostaux,codeDepartement,codeRegion,population&format=json&geometry=centre')
			.then(response => response.json().then(r => this.cities = r));
		},
		formSent(form) {
			this.disableForm = true;
			for (var i = 0, len = this.basketLines.length; i < this.basketLines; i++) {
				form.append('ordered_quantity[]', this.basketLines[i].quantity);
				form.append('fk_product[]', this.basketLines[i].byFour ? 2 : 1);
			}
			this.$ajax({
				url: '/order',
				method: 'POST',
				data: form,
				success: r => {
					console.log(r);
				},
				fail: e => {
					this.disableForm = false;
					this.$error(e);
				}
			});
			return;

			Stripe(this.stripePublicKey).redirectToCheckout({
			  // Make the id field from the Checkout Session creation API response
			  // available to this file, so you can provide it as parameter here
			  // instead of the {{CHECKOUT_SESSION_ID}} placeholder.
			  sessionId: '{{CHECKOUT_SESSION_ID}}'
			}).then(function (result) {
			  // If `redirectToCheckout` fails due to a browser or network
			  // error, display the localized error message to your customer
			  // using `result.error.message`.
			});
		}
	},
	mounted() {
		console.log(this.basketLines);
		if(this.basketLines === null || this.basketLines.length < 1) this.$router.push({name: 'root'});
	}
}