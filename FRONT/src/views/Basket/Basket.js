import { mapGetters } from "vuex";

export default {
	components: {},
	data() {
		return {

		};
	},
	computed: {
		...mapGetters({
			basketLines: 'getBasket',
		}),
	},
	watch: {
	},
	methods: {
	},
};