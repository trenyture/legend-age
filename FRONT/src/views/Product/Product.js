import Modal from "@/components/Modal/Modal.vue";
import Button from "@/components/Button/Button.vue";
import Input from "@/components/Input/Input.vue";
import Form from "@/components/Form/Form.vue";
import Notation from "@/components/Notation/Notation.vue";

export default {
	components: {Modal, Button, Input, Form, Notation},
	data() {
		return {
			quantity: 1,
			byFour: false,
			modalOpened: false,
			activeSlide: 0,
			avis: null,

			now: new Date(),
			isBlackFriday: false,
		};
	},
	computed: {
		finalPrice() {
			let unitPrice = this.byFour == true ? 99 : 29;
			if(this.isPromo) {
				unitPrice = unitPrice - this.isPromo
			}
			return parseFloat(this.quantity * unitPrice).toFixed(2);
		},
		normalPrice() {
			let unitPrice = this.byFour == true ? 99 : 29;
			return parseFloat(this.quantity * unitPrice).toFixed(2);
		},
		randomAvis() {
			if(this.avis === null || this.avis.length === 0) return null;
			console.log(this.avis);
			let avis = this.avis
				.map((a) => ({sort: Math.random(), value: a}))
				.sort((a, b) => a.sort - b.sort)
				.map((a) => a.value);
			return avis.length > 3 ? avis.slice(0, 3) : avis;
		},
		moyenne() {
			if(this.avis === null || this.avis.length === 0) return null;
			return this.avis.reduce((a, c) => a + parseInt(c.notation), 0) / this.avis.length;
		}
	},
	watch: {
		quantity(n, o) {
			if(n !== o && n < 1) {
				this.quantity = 1;
			}
		}
	},
	methods: {

		buyProduct() {
			window.fbq('track', 'AddToCart');
			this.$store.dispatch('addBasketLine', {quantity: this.quantity, byFour: this.byFour}).then(() => {
				this.modalOpened = true;
			});
		},

		loadAvis() {
			this.$ajax({
				url: '/comment',
				success: r => this.avis = r,
			});
		},

		printDate(date) {
			let d = new Date(date);
			return ('0' + d.getDate()).slice(-2) + '/' + ('0' + (1 + d.getMonth())).slice(-2) + '/' + d.getFullYear();
		}
	},

	beforeMount() {
		if(this.now >= new Date('2019-11-28 20:00:00') && this.now < new Date('2019-12-02 00:00:00')) {
			this.isBlackFriday = true;
			this.isPromo = 9.01;
		}
	},
	mounted() {
		this.loadAvis();
	},
	updated() {
		if(this.now >= new Date('2019-11-28 20:00:00') && this.now < new Date('2019-12-02 00:00:00')) {
			this.isBlackFriday = true;
			this.isPromo = 9.01;
		}
	}
};