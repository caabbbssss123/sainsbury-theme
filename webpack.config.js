const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = (env, argv) => {
	const isProduction = argv.mode === 'production';

	return {
		mode: argv.mode || 'production',
		devtool: isProduction ? false : 'source-map',
		entry: {
			theme: './assets/theme.js',
		},
		output: {
			path: path.resolve(__dirname, 'assets'),
			filename: 'js/[name].js',
			clean: false,
		},
		externals: {
			jquery: 'jQuery',
		},
		resolve: {
			extensions: ['.js', '.scss'],
		},
		watchOptions: {
			ignored: [
				'**/node_modules/**',
				'**/assets/js/theme.js',
				'**/assets/js/theme.js.map',
				'**/assets/css/theme.css',
				'**/assets/css/theme.css.map',
			],
		},
		module: {
			rules: [
				{
					test: /\.scss$/,
					use: [
						MiniCssExtractPlugin.loader,
						{
							loader: 'css-loader',
							options: {
								url: false,
								sourceMap: !isProduction,
							},
						},
						{
							loader: 'sass-loader',
							options: {
								implementation: require('sass'),
								sourceMap: !isProduction,
								sassOptions: {
									silenceDeprecations: ['import', 'global-builtin'],
								},
							},
						},
					],
				},
			],
		},
		plugins: [
			new MiniCssExtractPlugin({
				filename: 'css/[name].css',
			}),
		],
	};
};
