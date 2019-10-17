import Form from "@/components/Form/Form.vue";
import Button from "@/components/Button/Button.vue";
import Input from "@/components/Input/Input.vue";

export default {
	components: {Form, Button, Input},
	props: {
	},
	data() {
		return {
			pass: null,
			passCheck: null,
		};
	},
	computed: {
		isLogged() {
			return false;
		},
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