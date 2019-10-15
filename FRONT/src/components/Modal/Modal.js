export default {
	props: {
		opened: {
			type: Boolean,
			default: false,
		},
	},
	watch:{
		opened(newValue, oldValue){
			if(newValue != oldValue && newValue == false) {
				this.closingModal();
			}
		}
	},
	methods: {
		closingModal() {
			if(this.opened === true) {
				this.$emit('update:opened', false);
			}
			//On met un timeout de 3ms qui correspond à l'animation de fermeture de la modal
			setTimeout(() => {
				this.$emit('modalClosed');
			}, 300);
		},
		closeOnEscape(event) {
			if(event.keyCode == 27 && this.opened === true) {
				this.closingModal();
			}
		}
	},
	mounted() {
		document.addEventListener('keydown', this.closeOnEscape);
	},
	beforeDestroy() {
		document.removeEventListener('keydown', this.closeOnEscape);
	},
};
