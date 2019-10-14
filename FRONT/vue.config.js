module.exports = {
	configureWebpack: {
		// No need for splitting
		optimization: {
			splitChunks: false
		},
	},
	css: {
		extract: false,
		loaderOptions: {
			sass: {
				data: `@import "./src/_variables.scss";`
			}
		}
	},
};
