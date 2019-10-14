export default {
	components: {},
	data() {
		return {
			quantity: 1,
			byFour: false,
		};
	},
	computed: {
		finalPrice() {
			let unitPrice = this.byFour == true ? 99 : 29.90;
			return parseFloat(this.quantity * unitPrice).toFixed(2);
		}
	},
	watch: {
		quantity(n, o) {
			if(n !== o && n < 1) {
				this.quantity = 1;
			}
		}
	},
	methods: {},
};