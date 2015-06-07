module.exports = function(grunt) {
    // Chargement automatique de tous nos modules
    require('load-grunt-tasks')(grunt);

    // Configuration des plugins
    grunt.initConfig({

        copy: {
            src : {
                files: [
                    {
                        expand: true,
                        cwd: 'src/Manudev/KDOGuiBundle/Resources/public',
                        dest: 'web/assets/src',
                        src: ['js/**/*.js']
                    },
                    {
                        expand: true,
                        cwd: 'src/Manudev/KDOGuiBundle/Resources/public',
                        dest: 'web/assets/src',
                        src: ['css/**/*.css']
                    },
                    {
                        expand: true,
                        cwd: 'src/Manudev/KDOGuiBundle/Resources/public',
                        dest: 'web/assets/src',
                        src: ['less/**/*.less']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/modernizr',
                        dest: 'web/assets/src/libs',
                        src: ['modernizr.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/requirejs',
                        dest: 'web/assets/src/libs',
                        src: ['require.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/jquery/dist',
                        dest: 'web/assets/src/libs/jquery/js',
                        src: ['jquery.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/underscore',
                        dest: 'web/assets/src/libs',
                        src: ['underscore.js']
                    },
                    //{
                    //    dest: 'web/assets/src/libs/palas/palas.js',
                    //    src: 'bower_modules/palas/palas/js/script.js'
                    //},
                    //{
                    //    expand: true,
                    //    cwd: 'bower_modules/palas/palas/plugins',
                    //    dest: 'web/assets/src/libs/palas/plugins',
                    //    src: '**'
                    //},
                    //{
                    //    expand: true,
                    //    cwd: 'bower_modules/palas/palas/plugins',
                    //    dest: 'web/assets/libs/palas/plugins',
                    //    src: '**'
                    //},
                    //{
                    //    expand: true,
                    //    cwd: 'bower_modules/palas/palas/css',
                    //    dest: 'web/assets/libs/palas/css',
                    //    src: '**'
                    //},
                    //{
                    //    expand: true,
                    //    cwd: 'bower_modules/palas/palas/images',
                    //    dest: 'web/assets/libs/palas/images',
                    //    src: ['**/*']
                    //},
                    //{
                    //    dest: 'web/assets/libs/palas/palas.js',
                    //    src: 'bower_modules/palas/palas/js/script.js'
                    //},
                    {
                        expand: true,
                        cwd: 'bower_modules/angular-loading-bar/src',
                        dest: 'web/assets/src/libs/angular/css',
                        src: ['loading-bar.css']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/angular',
                        dest: 'web/assets/src/libs/angular/js',
                        src: ['angular.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/angularAMD',
                        dest: 'web/assets/src/libs/angular/js',
                        src: ['angularAMD.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/angular-loading-bar/src',
                        dest: 'web/assets/src/libs/angular/js',
                        src: ['loading-bar.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/angular-route',
                        dest: 'web/assets/src/libs/angular/js',
                        src: ['angular-route.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/angular-animate',
                        dest: 'web/assets/src/libs/angular/js',
                        src: ['angular-animate.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/angular-bootstrap',
                        dest: 'web/assets/src/libs/angular/js',
                        src: ['ui-bootstrap.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/angular-messages',
                        dest: 'web/assets/src/libs/angular/js',
                        src: ['angular-messages.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/jquery.appear',
                        dest: 'web/assets/src/libs/jquery/js',
                        src: ['jquery.appear.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/owlcarousel/owl-carousel',
                        dest: 'web/assets/src/libs/jquery/js',
                        src: ['owl.carousel.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/owlcarousel/owl-carousel',
                        dest: 'web/assets/src/libs/jquery/css',
                        src: ['owl.*.css']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/palas/palas/plugins/bootstrap/js',
                        dest: 'web/assets/src/libs/palas/js',
                        src: ['bootstrap.min.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/palas/palas/plugins/rs-plugin/css',
                        dest: 'web/assets/src/libs/palas/css/rs-plugin',
                        src: ['**/*.css']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/palas/palas/plugins/rs-plugin/assets',
                        dest: 'web/assets/src/libs/palas/css/rs-plugin/assets',
                        src: ['**/*.png']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/palas/palas/plugins/bootstrap/css',
                        dest: 'web/assets/src/libs/palas/css',
                        src: ['bootstrap.min.css']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/palas/palas/css',
                        dest: 'web/assets/src/libs/palas/css',
                        src: ['**/*.css']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/fontawesome/less',
                        dest: 'web/assets/src/libs/fontawesome/less',
                        src: ['**/*.less']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/fontawesome/fonts',
                        dest: 'web/assets/src/libs/fontawesome/fonts',
                        src: ['**/*.*']
                    }
                ]
            },

            dest : {
                files : [
                    {
                        expand: true,
                        cwd: 'web/assets/src/libs/fontawesome/fonts',
                        dest: 'web/assets/css/libs/fontawesome',
                        src: ['**/*.*']
                    },
                    {
                        expand: true,
                        cwd: 'web/assets/src/libs/palas/css/rs-plugin/assets',
                        dest: 'web/assets/css/libs/palas/assets',
                        src: ['**/*.png']
                    },
                ]
            }
        },

        cssmin: {
            combine: {
                options:{
                    report: 'gzip',
                    keepSpecialComments: 0,
                    sourceMap: true
                },
                files: [
                    {
                        expand: true,
                        cwd: 'web/assets/src/css',
                        src: '**/*.css',
                        dest: 'web/assets/css'
                    },
                    {
                        expand: true,
                        cwd: 'web/assets/src/libs/angular/css',
                        src: '**/*.css',
                        dest: 'web/assets/css/libs/angular'
                    },
                    {
                        expand: true,
                        cwd: 'web/assets/src/libs/jquery/css',
                        src: '**/*.css',
                        dest: 'web/assets/css/libs/jquery'
                    },
                    {
                        expand: true,
                        cwd: 'web/assets/src/libs/palas/css',
                        src: '**/*.css',
                        dest: 'web/assets/css/libs/palas'
                    }
                ]
            }
        },

        less: {
            dist: {
                options: {
                    compress: true,
                    cleancss: true,
                    yuicompress: true,
                    optimization: 3,
                    //sourceMap: true,
                    //sourceMapFilename: 'web/assets/less_main.css.map',
                    //sourceMapURL: '../less_main.css.map',
                    //sourceMapBasepath: 'web/assets/gui',
                    //sourceMapRootpath: './'
                },
                files:
                    [
                        {
                            expand: true,
                            cwd: 'web/assets/src/less',
                            src: '**/*.less',
                            dest: 'web/assets/css',
                            ext: '.css'
                        },
                        {
                            expand: true,
                            cwd: 'web/assets/src/libs/fontawesome/less',
                            src: 'font-awesome.less',
                            dest: 'web/assets/css/libs',
                            ext: '.css'
                        }
                ]

              //      { "web/assets/css/main.css": "web/assets/src/less/main.less" }
            }
        },
        fontAwesomeVars: {
            main: {
                variablesLessPath: 'web/assets/src/libs/fontawesome/less/variables.less',
                fontPath: 'fontawesome'
                      //NOTE: this must be relative to FINAL, compiled .css file -
                      // NOT the variables.less file! For example, this would be the
                      // correct path if the compiled css file is main.css which is in
                      // 'src/build' and the font awesome font is in
                      // 'src/bower_components/font-awesome/fonts'
                      // - since to get from main.css to the fonts directory,
                      // you first go back a directory then go into
                      // bower_components > font-awesome > fonts.
            }
        },

        uglify: {
            options: {
                beautify: false,
                mangle: false,
                sourceMap: true,
                compress: true,
                report: 'gzip',
            },
            dist: {
                files: [

                    //{
                    //   src: ['web/assets/src/js/**/*.js', '!web/assets/src/js/main.js'],
                    //   dest: 'web/assets/js/app.js'
                    //},
                    //{
                    //    src: ['web/assets/src/js/main.js'],
                    //    dest: 'web/assets/js/main.js'
                    //},
                    {
                        expand: true,
                        cwd: 'web/assets/src/js',
                        src: '**/*.js',
                        dest: 'web/assets/js'
                    },

                    // Simple lib (require, underscore, ...)
                    {
                        expand: true,
                        cwd: 'web/assets/src/libs',
                        src: '*.js',
                        dest: 'web/assets/js/libs'
                    },
                    // Angular
                    {
                        expand: true,
                        cwd: 'web/assets/src/libs/angular/js',
                        src: '**/*.js',
                        dest: 'web/assets/js/libs/angular'
                    },
                    // Jquery
                    {
                        expand: true,
                        cwd: 'web/assets/src/libs/jquery/js',
                        src: '**/*.js',
                        dest: 'web/assets/js/libs/jquery'
                    },
                    // Palas
                    {
                        expand: true,
                        cwd: 'web/assets/src/libs/palas/js',
                        src: '**/*.js',
                        dest: 'web/assets/js/libs/palas'
                    },
                    /*
                    {
                        expand: true,
                        cwd: 'web/assets/src/libs/palas',
                        src: '** /*.js',
                        dest: 'web/assets/libs/palas'
                    }*/
                ]
            }
        },

        watch: {
            javascript: {
                files: ['src/Manudev/KDOGuiBundle/Resources/public/js/**/*.js'],
                tasks: ['default']
            },
            less: {
                files: ['src/Manudev/KDOGuiBundle/Resources/public/less/**/*.less'],
                tasks: ['default']
            }
        },

        clean: {
            build: {
                src: ["web/assets"]
            }
        }
    });

    // Déclaration des différentes tâches
    grunt.registerTask('default', ['clean', 'copy', 'css', 'js']);
    grunt.registerTask('css', [ 'fontAwesomeVars', 'less', 'cssmin']);
    grunt.registerTask('js', ['uglify']);
};
