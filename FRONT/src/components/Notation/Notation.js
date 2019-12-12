// import something from "@/";

export default {
	components: {},
	props: {
		notation: {
			type: Number,
			default: 0,
			validator: (value) => value >= 0 && value <= 5,
		}
	},
	data() {
		return {
		};
	},
	computed: {
	},
	watch: {
	},
	methods: {
	},
}