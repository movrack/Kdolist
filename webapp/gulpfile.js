var gulp = require("gulp");
var clean = require('gulp-clean');
var gutil = require("gulp-util");
var webpack = require("webpack");
var del = require('del');
//var WebpackDevServer = require("webpack-dev-server");

gulp.task('default', ['clean', 'build']);



//////////////////////////////////////
// Clean
gulp.task('clean', function () {
    //https://github.com/gulpjs/gulp/blob/master/docs/recipes/delete-files-folder.md
    return del([
        'build',
        'app/app.js*'
    ]);
});



//////////////////////////////////////
// Build

// modify some webpack config options
var webpackConfig = require("./webpack.config.js");
var myWebpackConfig = Object.create(webpackConfig);
//myWebpackConfig.devtool = "sourcemap";
//myWebpackConfig.debug = true;
var webpackCompiler = webpack(myWebpackConfig);

gulp.task("build", function(callback) {
    webpackCompiler.run(function(err, stats) {
        if(err) throw new gutil.PluginError("webpack", err);
        gutil.log("[webpack]", stats.toString({
            // output options
        }));
        callback();
    });
});