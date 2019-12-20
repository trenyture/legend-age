export default {
	components: {},
	data() {
		return {
		};
	},
	computed: {},
	watch: {},
	methods: {
		scrollToVideo() {
			let wHeight = window.innerHeight,
			animation = 100,
			start = window.pageYOffset,
			frames = (wHeight - start) / animation,
			interval = window.setInterval(() => {
				start += frames;
				if(start >= wHeight) {
					start = wHeight;
					window.clearInterval(interval);
				}
				window.scrollTo(0, start);
			}, 1);
		},
	},
};