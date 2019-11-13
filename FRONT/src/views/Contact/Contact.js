import {mapGetters} from "vuex";

import Form from "@/components/Form/Form.vue";
import Input from "@/components/Input/Input.vue";
import Button from "@/components/Button/Button.vue";

export default {
	components: {Form, Input, Button},
	data() {
		return {
		};
	},
	computed: {
		...mapGetters({
			disabled: "contactFormSent",
		}),
	},
	watch: {
	},
	methods: {
		formSent(r) {
			if(!r) {
				this.$alert.swal({
					type: "error",
					title: "Problème",
					message: "Il y a eu un problème lors de l'envoi de votre message, veuillez rééssayer ultérieurement..."
				});
			}
			else {
				window.fbq('track', 'Contact');
				this.$store.dispatch('contactFormSent', true).then(() => {
					this.$alert.swal({
						type: "success",
						title: "Merci",
						message: "Votre message a bien été envoyé, nous le traiterons dans les plus brefs délais."
					});
				})
			}
		}
	},
}