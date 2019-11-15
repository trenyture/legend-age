export default {
	components: {},
	data() {
		return {
			actived: false,
		};
	},
	computed: {},
	watch: {
		$route(n, o) {
			this.actived = false;
		}
	},
	methods: {
		closeMenu() {
			if(this.actived === true && !event.target.closest('.main-menu')) {
				this.actived = false;
			}
		}
	},
	mounted(){
		document.addEventListener('click', this.closeMenu);
	},
	beforeDestroy() {
		document.removeEventListener('click', this.closeMenu);
	}
};