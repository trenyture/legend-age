import { mapGetters } from "vuex";

export default {
	components: {},
	data() {
	},
	computed: {
		...mapGetters({
			basket: 'getBasket',
		});
	},
	watch: {
	},
	methods: {},
};