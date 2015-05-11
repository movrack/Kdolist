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
                        dest: 'web/assets/gui/src',
                        src: ['js/**/*.js']
                    },
                    {
                        expand: true,
                        cwd: 'src/Manudev/KDOGuiBundle/Resources/public',
                        dest: 'web/assets/gui/src',
                        src: ['css/**/*.css']
                    },
                    {
                        expand: true,
                        cwd: 'src/Manudev/KDOGuiBundle/Resources/public',
                        dest: 'web/assets/gui/src',
                        src: ['less/**/*.less']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/modernizr',
                        dest: 'web/assets/gui/src/libs/js',
                        src: ['modernizr.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/requirejs',
                        dest: 'web/assets/gui/src/libs/js',
                        src: ['require.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/jquery/dist',
                        dest: 'web/assets/gui/src/libs/js',
                        src: ['jquery.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/underscore',
                        dest: 'web/assets/gui/src/libs/js',
                        src: ['underscore.js']
                    },
                    {
                        dest: 'web/assets/gui/src/libs/palas/palas.js',
                        src: 'bower_modules/palas/palas/js/script.js'
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/palas/palas/plugins',
                        dest: 'web/assets/gui/src/libs/palas/plugins',
                        src: '**'
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/palas/palas/plugins',
                        dest: 'web/assets/gui/libs/palas/plugins',
                        src: '**'
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/palas/palas/css',
                        dest: 'web/assets/gui/libs/palas/css',
                        src: '**'
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/palas/palas/images',
                        dest: 'web/assets/gui/libs/palas/images',
                        src: ['*.png', '*.gif', '*.jpg', 'patterns/*.png']
                    },
                    {
                        dest: 'web/assets/gui/libs/palas/palas.js',
                        src: 'bower_modules/palas/palas/js/script.js'
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/angular',
                        dest: 'web/assets/gui/src/libs/js',
                        src: ['angular.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/angular-route',
                        dest: 'web/assets/gui/src/libs/js',
                        src: ['angular-route.js']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/angularAMD',
                        dest: 'web/assets/gui/src/libs/js',
                        src: ['angularAMD.js']
                    },
                ]
            }
        },

        cssmin: {
            combine: {
                options:{
                    report: 'gzip',
                    keepSpecialComments: 0,
                    sourceMap: false
                },
                files: [
                    {
                        expand: true,
                        cwd: 'web/assets/gui/src/css',
                        src: '**/*.css',
                        dest: 'web/assets/gui/css'
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
                    sourceMapFilename: 'web/assets/gui/less_main.css.map',
                    sourceMapURL: '../less_main.css.map',
                    sourceMapBasepath: 'web/assets/gui',
                    sourceMapRootpath: './'
                },
                files:
                    [
                    {
                        expand: true,
                        cwd: 'web/assets/gui/src/less',
                        src: '**/*.less',
                        dest: 'web/assets/gui/css',
                        ext: '.css'
                    }
                ]

              //      { "web/assets/gui/css/main.css": "web/assets/gui/src/less/main.less" }
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
                       cwd: 'web/assets/gui/src/js',
                       src: '**/*.js',
                       dest: 'web/assets/gui/js'
                    },
                    {
                        expand: true,
                        cwd: 'web/assets/gui/src/libs/js',
                        src: '**/*.js',
                        dest: 'web/assets/gui/libs/js'
                    },
                    /*
                    {
                        expand: true,
                        cwd: 'web/assets/gui/src/libs/palas',
                        src: '** /*.js',
                        dest: 'web/assets/gui/libs/palas'
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
