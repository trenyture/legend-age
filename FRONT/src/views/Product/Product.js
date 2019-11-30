import Modal from "@/components/Modal/Modal.vue";
import Button from "@/components/Button/Button.vue";
import Input from "@/components/Input/Input.vue";
import Form from "@/components/Form/Form.vue";

export default {
	components: {Modal, Button, Input, Form},
	data() {
		return {
			quantity: 1,
			byFour: false,
			modalOpened: false,
			activeSlide: 0,

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
		}
	},

	beforeMount() {
		if(this.now >= new Date('2019-11-28 20:00:00') && this.now < new Date('2019-12-02 00:00:00')) {
			this.isBlackFriday = true;
			this.isPromo = 9.01;
		}
	},
	updated() {
		if(this.now >= new Date('2019-11-28 20:00:00') && this.now < new Date('2019-12-02 00:00:00')) {
			this.isBlackFriday = true;
			this.isPromo = 9.01;
		}
	}
};