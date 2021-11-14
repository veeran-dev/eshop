const path = require('path');
const autoprefixer = require('autoprefixer');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
	entry: ['./app/app.jsx', './sass/ui.scss'],
	module: {
		rules: [
			{
				test: /\.(js|jsx)$/,
				exclude: /node_modules/,
				use: [
					'babel-loader'
				]
			},
			{
				test: /\.(png|svg|jpg|gif|jpeg|woff|woff2|eot|ttf|otf)$/,
				use: [
					'file-loader'
				]
			},
			{
			    test: /\.(sa|sc|c)ss$/,
			    use: [
			        MiniCssExtractPlugin.loader,
			        {
			            loader: "css-loader",
			            options: {
			            	url: false
			            }
			        },
			        {
			            loader: "sass-loader",
			            options: {}
			        }
			    ]
			}
		]
	},
	resolve: {
		extensions: ['.js', '.jsx', '.css', '.scss'],
		alias: {
			react: path.resolve(__dirname, './node_modules/react'),
			React: path.resolve(__dirname, './node_modules/react')
		}
	},
	plugins: [
		new CleanWebpackPlugin(['dist']),
		new MiniCssExtractPlugin({
			filename: 'ui.css'
		})
	],
	output: {
		filename: 'bundle.js',
		path: path.resolve(__dirname, 'dist')
	}
};