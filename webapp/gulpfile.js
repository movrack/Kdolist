var gulp = require("gulp");
var gutil = require("gulp-util");
var webpack = require("webpack");
//var WebpackDevServer = require("webpack-dev-server");

gulp.task('default', ['webpack']);

// modify some webpack config options
var webpackConfig = require("./webpack.config.js");
var myWebpackConfig = Object.create(webpackConfig);
//myWebpackConfig.devtool = "sourcemap";
//myWebpackConfig.debug = true;
var webpackCompiler = webpack(myWebpackConfig);

gulp.task("webpack", function(callback) {
    webpackCompiler.run(function(err, stats) {
        if(err) throw new gutil.PluginError("webpack", err);
        gutil.log("[webpack]", stats.toString({
            // output options
        }));
        callback();
    });
});