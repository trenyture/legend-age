const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const VueLoaderPlugin = require('vue-loader/lib/plugin');

module.exports = {
	entry: './src/main.js',
	module: {
		rules: [
			{
				test: /\.js$/,
				use: 'babel-loader'
			},
			{
				test: /\.vue$/,
				use: 'vue-loader'
			},
			{
				test: [/\.css$/, /\.scss$/],
				use: [
					'vue-style-loader',
					'css-loader',
					{
						loader: "sass-loader",
						options: {
							sourceMap: true,
							prependData: '@import "./_variables.scss";',
						}
					}
				]
			},
		]
	},
	devServer: {
		open: true,
		hot: true,
		historyApiFallback: true,
	},
	resolve: {
		alias: {
			"@": path.resolve(__dirname, 'src'),
		},
	},
	plugins: [
		new HtmlWebpackPlugin({
			template: './src/index.html',
		}),
		new VueLoaderPlugin(),
	]
};