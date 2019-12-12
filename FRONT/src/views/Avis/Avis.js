import Notation from "@/components/Notation/Notation.vue";
import Form from "@/components/Form/Form.vue";
import Input from "@/components/Input/Input.vue";
import Button from "@/components/Button/Button.vue";

export default {
	components: { Notation, Form, Input, Button },
	props: {
	},
	data() {
		return {
			note: null,
		};
	},
	computed: {
	},
	watch: {
		note(n,o) {
			console.log(n, o);
		}
	},
	methods: {
		formSent(event) {
			this.$alert.swal({
				type: 'success',
				title: 'Merci beaucoup',
				message: "Merci de nous avoir envoyé votre commentaire et à très bientôt",
				callback: () => {
					return this.$router.push({name: 'root'});
				}
			})
		}
	},
}