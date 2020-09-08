import Header from "@/components/Header/Header.vue"
import Footer from "@/components/Footer/Footer.vue"
import Bandeau from "@/components/Bandeau/Bandeau.vue"
import Button from "@/components/Button/Button.vue"

export default {
	components: { Header, Footer, Bandeau },
	data() {
		return {
			now : new Date(),
			console,
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
	methods: {
		buyPromo() {
			window.fbq('track', 'AddToCart');
			this.$store.dispatch('addBasketLine', {quantity: 1, byFour: true}).then(() => {
				this.$alert.swal({
					type: "success",
					title: "Ajouté",
					message: "L'offre promotionnelle a bien été ajoutée au panier",
					confirm: "Voir mon panier",
					cancel: "Fermer",
					callback: r => {
						if(r.value) {
							this.$router.push({ name: "basket" });
						}
					}
				});
			});
		},
	},
};