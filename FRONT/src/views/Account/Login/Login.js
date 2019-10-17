import Form from "@/components/Form/Form.vue";
import Button from "@/components/Button/Button.vue";
import Input from "@/components/Input/Input.vue";
import Modal from "@/components/Modal/Modal.vue";

export default {
	components: {Form, Button, Input, Modal},
	props: {
	},
	data() {
		return {
			pass: null,
			passCheck: null,
			modalOpened: false,
			email: null,
		};
	},
	computed: {
		strongPassword() {
			if(this.pass === null) return true;
			return this.pass == this.passCheck;
		},
		samePasswords() {
			if(this.pass === null || this.passCheck === null) return true;
			return this.pass == this.passCheck;
		},
	},
	watch: {
	},
	methods: {
	},
}