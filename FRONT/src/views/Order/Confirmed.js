import {mapGetters} from "vuex";

export default {
	data() {
		return {
			totalPrice: 0,
			now: new Date(),
		};
	},
	computed: {
		...mapGetters({
			basketLines: 'getBasket',
		})
	},

	beforeMount() {
		if(this.now >= new Date('2019-11-28 20:00:00') && this.now < new Date('2019-12-02 00:00:00')) {
			this.isBlackFriday = true;
			this.isPromo = 9.01;
		}
	},
	mounted() {

		if(!this.basketLines || this.basketLines.length === 0 || !this.$route.params.orderId || !this.$route.params.type) return this.$router.push({
			name: 'root',
		});

		this.totalPrice = this.basketLines.reduce((r,e) => {
			return r + e.quantity * (e.byFour == true ? 99 : (29 - (this.isPromo || 0)));
		}, 0);

		if(this.isBlackFriday) {
			this.totalPrice += 2.50;
		}

		window.fbq('track', 'Purchase', {value: this.totalPrice, currency: 'EUR'});

		let fd = new FormData();
		fd.append('session_id', this.$route.params.orderId);
		fd.append('payer', this.$route.params.type);

		for(var i = 0, len = this.basketLines.length; i < len; i++) {
			fd.append('ordered_quantity[]', this.basketLines[i].quantity);
			fd.append('fk_product[]', this.basketLines[i].byFour ? 2 : 1);
		}

		this.$ajax({
			url: '/payment/confirmed',
			method: 'POST',
			data: fd,
			success: r => {
				if(r === true) {
					this.$store.dispatch('deleteAllBasketLine');
				}
			},
		});
	},
	updated() {
		if(this.now >= new Date('2019-11-28 20:00:00') && this.now < new Date('2019-12-02 00:00:00')) {
			this.isBlackFriday = true;
			this.isPromo = 9.01;
		}
	}
}