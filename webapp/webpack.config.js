var webpack = require('webpack');
var path = require('path');
var BrowserSyncPlugin = require('browser-sync-webpack-plugin');

module.exports = {
    entry: './app/app.ts',
    output: { filename: 'app/app.js' }, //path: path.resolve(__dirname, './build'), filename: '[name].js' },
    //devtools: 'source-map',
    resolve: {
        modulesDirectories: [ 'node_modules', 'app/vendor' ],
        extensions: ['', '.less', '.webpack.js', '.web.js', '.ts', '.jsx', '.js']
    },
    plugins: [

        new BrowserSyncPlugin({
            host: 'localhost',
            port: 3000,
            server: { baseDir: ['app'] },
            files: ["index.html", "app.js"]
        })
        //, new webpack.optimize.UglifyJsPlugin()
    ],

    module: {
        loaders: [
            { test: /\.less$/, loader: "style!css!less"},
            { test: /\.ts$/, loader: 'ts' },

            {
                test: /\.jsx?$/,
                exclude: /(node_modules|bower_components)/,
                loader: 'babel'
                //loader: 'babel?optional[]=runtime'
            }
        ]
    }
}