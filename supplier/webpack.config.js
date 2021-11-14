const path = require('path');
const autoprefixer = require('autoprefixer');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const HtmlWebPackPlugin = require("html-webpack-plugin");
const BundleAnalyzerPlugin = require("webpack-bundle-analyzer").BundleAnalyzerPlugin;
module.exports = {
  entry: ['./src/app.js', './src/assets/sass/ui.scss'],
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, "dist"),
    publicPath: 'dist/'
  },
  watch: true,
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
  optimization: {
    splitChunks: {
        cacheGroups: {
            default: false,
            vendors: false,
            // vendor chunk
            vendor: {
                // sync + async chunks
                chunks: 'all',
                // import file path containing node_modules
                test: /node_modules/
            }
        }
    }
  },
  plugins: [
    // new BundleAnalyzerPlugin(),
    new HtmlWebPackPlugin({
      template: path.resolve(__dirname,"./src/index.html"),
      filename: path.resolve(__dirname,"./index.html")
    }),
    new CleanWebpackPlugin(),
    new MiniCssExtractPlugin({
      filename: '[name].css'
    })
  ],
  // output: {
  //   filename: '[name].bundle.js',
  //   chunkFilename: '[name].bundle.js',
  //   path: path.resolve(__dirname, 'dist'),
  //   publicPath: './dist/'
  // },
  optimization: {
    splitChunks: {
        cacheGroups: {
          commons: {
            name: 'commons',
            chunks: 'all',
            minChunks: 2,
            enforce: true
          }
        }
      }
  }
};