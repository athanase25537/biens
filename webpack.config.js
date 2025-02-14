const path = require('path');

module.exports = {
  mode: 'production',
  entry: './assets/js/app.js',
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'Public/assets/js')
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: [
          'style-loader', 
          'css-loader'
        ]
      },
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env']
          }
        }
      }
    ]
  },
  devServer: {
    static: {
      directory: path.join(__dirname, 'Public')
    },
    compress: true,
    port: 9000
  }
};
