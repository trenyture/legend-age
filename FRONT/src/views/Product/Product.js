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
			console,
		};
	},
	computed: {
		finalPrice() {
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
};