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
                        dest: 'web/assets/src/libs/js',
                        src: ['modernizr.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/requirejs',
                        dest: 'web/assets/src/libs/js',
                        src: ['require.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/jquery/dist',
                        dest: 'web/assets/src/libs/js',
                        src: ['jquery.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/underscore',
                        dest: 'web/assets/src/libs/js',
                        src: ['underscore.js']
                    },
                    {
                        dest: 'web/assets/src/libs/palas/palas.js',
                        src: 'bower_modules/palas/palas/js/script.js'
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/palas/palas/plugins',
                        dest: 'web/assets/src/libs/palas/plugins',
                        src: '**'
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/palas/palas/plugins',
                        dest: 'web/assets/libs/palas/plugins',
                        src: '**'
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/palas/palas/css',
                        dest: 'web/assets/libs/palas/css',
                        src: '**'
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/palas/palas/images',
                        dest: 'web/assets/libs/palas/images',
                        src: ['**/*']
                    },
                    {
                        dest: 'web/assets/libs/palas/palas.js',
                        src: 'bower_modules/palas/palas/js/script.js'
                    },
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
                        dest: 'web/assets/libs/css/angular'
                    }
                ]
            }
        },

        less: {
            dist: {
                options: {
                    compress: true,
                    cleancss:true,
                    yuicompress: true,
                    optimization: 3,
                    sourceMap: true,
                    sourceMapFilename: 'web/assets/less_main.css.map',
                    sourceMapURL: '../less_main.css.map',
                    sourceMapBasepath: 'web/assets/gui',
                    sourceMapRootpath: './'
                },
                files:
                    [
                    {
                        expand: true,
                        cwd: 'web/assets/src/less',
                        src: '**/*.less',
                        dest: 'web/assets/css',
                        ext: '.css'
                    }
                ]

              //      { "web/assets/css/main.css": "web/assets/src/less/main.less" }
            }
        },
        uglify: {
            options: {
                beautify: true,
                mangle: false,
                /*{
                    except: ['jquery', 'underscore']
                },*/
                sourceMap: true
            },
            dist: {
                files: [
                    {
                       expand: true,
                       cwd: 'web/assets/src/js',
                       src: '**/*.js',
                       dest: 'web/assets/js'
                    },
                    {
                        expand: true,
                        cwd: 'web/assets/src/libs/js',
                        src: '**/*.js',
                        dest: 'web/assets/libs/js'
                    },
                    {
                        expand: true,
                        cwd: 'web/assets/src/libs/angular/js',
                        src: '**/*.js',
                        dest: 'web/assets/libs/js/angular'
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
                src: ["web/assets", "web/palas"]
            }
        }
    });

    // Déclaration des différentes tâches
    grunt.registerTask('default', ['clean', 'copy', 'css', 'js']);
    grunt.registerTask('css', ['less', 'cssmin']);
    grunt.registerTask('js', ['uglify']);
};
