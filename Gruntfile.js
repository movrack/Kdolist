module.exports = function(grunt) {
    // Chargement automatique de tous nos modules
    require('load-grunt-tasks')(grunt);

    // Configuration des plugins
    grunt.initConfig({
        less: {
            dist: {
                options: {
                    compress: true,
                    yuicompress: true,
                    optimization: 3
                },
                files: {
                    "web/assets/tmp/css/vendor.css": [
                        "bower_modules/bootstrap/less/bootstrap.less",
                        "bower_modules/fontawesome/less/font-awesome.less"
                    ],
                    "web/assets/tmp/css/app.css": [
                        "web/assets/src/CoreBundle/Resources/public/css/core.css",
                        "web/assets/src/UserBundle/Resources/public/css/user.css",
                        "web/assets/src/KDOBundle/Resources/public/css/kdo.css"
                    ]
                }
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
                        cwd: 'web/assets/tmp/css',
                        src: '**/*.css',
                        dest: 'web/assets/css',
                        ext: '.css'
                    }
                ]
            }
        },

        uglify: {
            options: {
                beautify: false,
                mangle: {
                    except: ['jquery', 'underscore']
                },
                sourceMap: true
            },
            dist: {
                files: [
                    {
                        'web/assets/js/require.js' : [
                            "bower_modules/requirejs/require.js"
                        ],
                        'web/assets/js/jquery.js' : [
                            "bower_modules/jquery/dist/jquery.min.js"
                        ],
                        'web/assets/js/angular.min.js' : [
                            "bower_modules/angular/angular.min.js"
                        ],
                        'web/assets/js/modernizr.min.js' : [
                            "bower_modules/modernizr/modernizr.js"
                        ],
                        'web/assets/js/bootstrap.js': [
                            "bower_modules/bootstrap/dist/js/bootstrap.min.js"
                        ],
                        'web/assets/js/boot.js' : [
                            "src/Manudev/CoreBundle/Resources/public/js/boot.js"
                        ],
                        'web/assets/js/main.js' : [
                            "web/assets/src/CoreBundle/Resources/public/js/main.js",
                            "web/assets/src/UserBundle/Resources/public/js/main.js",
                            "web/assets/src/KDOBundle/Resources/public/js/main.js"
                        ],
                        'web/assets/js/app.js' : [
                            "web/assets/src/KDOGuiBundle/Resources/public/js/app.js"
                        ]
                    },
                    {
                        expand: true,
                        cwd: 'web/assets/src/KDOBundle/Resources/public/js',
                        src: '*/**/*.js',
                        dest: 'web/assets/js/kdo'
                    },
                    {
                        expand: true,
                        cwd: 'web/assets/src/UserBundle/Resources/public/js',
                        src: '*/**/*.js',
                        dest: 'web/assets/js/user'
                    },
                    {
                        expand: true,
                        cwd: 'web/assets/src/CoreBundle/Resources/public/js',
                        src: '*/**/*.js',
                        dest: 'web/assets/js/core'
                    },
                    {
                        expand: true,
                        cwd: 'web/assets/src/GuiBundle/Resources/public/js',
                        src: '*/**/*.js',
                        dest: 'web/assets/js/gui'
                    }
                ]
            }
        },
        copy: {
            src: {
                files: [
                    {
                        expand: true,
                        cwd: 'src/Manudev/',
                        dest: 'web/assets/src',
                        src: ['**/Resources/public/js/**/*.js']
                    },
                    {
                        expand: true,
                        cwd: 'src/Manudev/',
                        dest: 'web/assets/src',
                        src: ['**/Resources/public/css/**/*.css']
                    },
                    {
                        expand: true,
                        cwd: 'src/Manudev/',
                        dest: 'web/assets/src',
                        src: ['**/Resources/public/less/**/*.less']
                    }
                ]
            },
            dist: {
                files: [
                    {
                        expand: true,
                        cwd: 'bower_modules/fontawesome/fonts',
                        dest: 'web/assets/fonts',
                        src: ['**']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/html5-boilerplate/dist',
                        dest: 'web/',
                        src: ['404.html', '*.xml', '*.txt', '*.png']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/html5-boilerplate/dist/css',
                        dest: 'web/assets/css',
                        src: ['main.css', 'normalize.css']
                    },
                    {
                        expand: true,
                        cwd: 'bower_modules/html5-boilerplate/dist/js',
                        dest: 'web/assets/js',
                        src: ['plugins.js']
                    }
                ]
            }
        },
        watch: {
            css: {
                files: [
                    'src/Manudev/*/Resources/public/css/**/*.less',
                    'src/Manudev/*/Resources/public/css/**/*.css'
                ],
                tasks: ['css']
            },
            javascript: {
                files: ['src/Manudev/*/Resources/public/js/**/*.js'],
                tasks: ['javascript']
            }
        }
    });

    // Déclaration des différentes tâches
    grunt.registerTask('default', ['copy:dist', 'copy:src', 'css', 'javascript']);
    grunt.registerTask('css', ['copy:dist', 'copy:src', 'less','cssmin']);
    grunt.registerTask('javascript', ['copy:dist', 'copy:src', 'uglify']);
};