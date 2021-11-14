const merge = require('webpack-merge');
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const common = require('./webpack.common.js');

module.exports = merge(common, {
	mode: 'production',
	devtool: 'source-map',
	stats: {
		warnings: false
	},
	optimization: {
	    minimizer: [
			new UglifyJsPlugin({
				cache: true,
				parallel: true,
				uglifyOptions: {
					warnings: false,
					output: {
						comments: false
					},
				}
			}),
			new OptimizeCSSAssetsPlugin({
		      cssProcessorOptions: {
		        safe: true,
		        discardComments: { removeAll: true },
		      },
		    })
		],
	},
});