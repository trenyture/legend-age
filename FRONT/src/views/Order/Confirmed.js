import {mapGetters} from "vuex";

export default {
	data() {
		return {
			totalPrice: 0,
		};
	},
	computed: {
		...mapGetters({
			basketLines: 'getBasket',
		})
	},
	mounted() {

		if(!this.basketLines || this.basketLines.length === 0 || !this.$route.params.orderId || !this.$route.params.type) return this.$router.push({
			name: 'root',
		});

		this.totalPrice = this.basketLines.reduce((r,e) => {
			return r + e.quantity * (e.byFour == true ? 99 : (29 - (this.isPromo || 0)));
		}, 0);
		window.fbq('track', 'Purchase', {value: this.totalPrice, currency: 'EUR'});

		let fd = new FormData();
		fd.append('session_id', this.$route.params.orderId);
		fd.appedn('payer', this.$route.params.type);

		this.$ajax({
			url: '/order/',
			method: 'POST',
			data: fd,
			success: r => {
				var router = this.$router;
				this.$store.dispatch('deleteAllBasketLine').then(() => {
					this.$alert.swal({
						type: 'success',
						title: 'Merci',
						message: "Votre commande a bien été enregistrée et nous la traiterons dans les plus brefs délais.",
						callback: () => {
							router.push({name: 'basket'});
						}
					});
				})
			},
		});
	}
}