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
			return this.countries !== null	
				&& !this.$route.params.stripeId;
		},
		...mapGetters({
			basketLines: 'getBasket',
		}),
		totalPrice() {
			return this.basketLines.reduce((r,e) => {
				return r + e.quantity * (e.byFour == true ? 99 : (29 - (this.isPromo || 0)));
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
			for (var i = 0, len = this.basketLines.length; i < len; i++) {
				form.append('ordered_quantity[]', this.basketLines[i].quantity);
				form.append('fk_product[]', this.basketLines[i].byFour ? 2 : 1);
			}

			this.$ajax({
				url: '/order',
				method: 'POST',
				data: form,
				success: r => {
					Stripe(this.stripePublicKey).redirectToCheckout({
						sessionId: r.stripe_id,
					});
				},
				fail: e => {
					this.disableForm = false;
					this.$error(e);
				}
			});
			return;
		}
	},
	beforeMount(){
		if(this.$route.params.stripeId) {
			let fd = new FormData();
			fd.append('session_id', this.$route.params.stripeId);
			this.$ajax({
				url: '/order/test',
				method: 'POST',
				data: fd,
				success: r => {
					var router = this.$router;
					this.$store.dispatch('deleteAllBasketLine').then(() => {
						this.$alert.swal({
							type: 'success',
							title: 'Merci',
							message: "Votre commande a bien été enregistrée et nous la traiterons dans les plus brefs délais.",
							callback() {
								router.push({name: 'basket'});
							}
						});
					})
				},
				fail: e => {
					var router = this.$router;
					this.$alert.swal({
						type: 'error',
						title: 'Erreur',
						message: "Il y a eu un problème lors du paiement de la commande",
						callback() {
							router.push({name: 'basket'});
						}
					});
				}
			});
		}
	},
	mounted() {
		if(this.basketLines === null || this.basketLines.length < 1) this.$router.push({name: 'root'});

	}
}