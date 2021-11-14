var path = require('path');
var webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');

// For development mode only
//var BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
 
module.exports = {
  entry: ['./app/app.jsx', './sass/ui.scss'],
  output: { path: __dirname+'/dist/', filename: 'bundle.js' },
  watch: true,
  // devtool: 'source-map',
  module: {
    rules: [
      {
        test: /.(js|jsx)?$/,
        use: [ 
          { 
            loader: 'babel-loader',
            options: {
              presets: ['es2015', 'react', 'babel-preset-stage-0']
            }
          } 
        ],
        exclude: /node_modules/
      },
      {
        test: /\.svg$/,
        use: [ { loader: 'raw-loader' } ],
        exclude: /node_modules/
      },
      {
        test: /\.(scss|css)$/,
        use: ExtractTextPlugin.extract({
          fallback: 'style-loader',
          use: [
            { 
              loader: 'css-loader',
              options: {
                url: false,
                minimize: true,
                sourceMap: true
              } 
            }, 
            {
              loader: 'sass-loader',
              options: {
                sourceMap: true
              }
            }
          ]
        }),
        exclude: /node_modules/
      }
    ]
  },
  resolve: {
      extensions: ['.js','.jsx', '.ts'],
      alias: {
        react: path.resolve(__dirname, './node_modules/react'),
        React: path.resolve(__dirname, './node_modules/react')
      }
  },
  plugins: [ 
    new webpack.DefinePlugin({
      'process.env':{
        'NODE_ENV': JSON.stringify('production')
      }
    }),
    // new webpack.optimize.UglifyJsPlugin({ // For production mode
    //   compressor: {
    //     warnings: false,
    //   },
    //   output: {
    //     comments: false,
    //     beautify: false,
    //   },
    //   sourceMap: false,
    // }),
    new ExtractTextPlugin('ui.css'),
    /* For development mode only
    new BundleAnalyzerPlugin() */
  ]
};