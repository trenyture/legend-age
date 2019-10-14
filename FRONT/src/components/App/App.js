import Header from "@/components/Header/Header.vue"
import Footer from "@/components/Footer/Footer.vue"
import Bandeau from "@/components/Bandeau/Bandeau.vue"

export default {
	components: { Header, Footer, Bandeau },
	data() {
		return {
		};
	},
	computed: {},
	watch: {
		$route: {
			deep:true,
			immediate: true,
			handler(n, o) {
				if(n.meta.pageTitle) {
					let title = n.meta.pageTitle instanceof Function
						? n.meta.pageTitle()
						: n.meta.pageTitle;
					document.title = title + ' - Legend Age';
				}
			}
		}
	},
	methods: {},
};