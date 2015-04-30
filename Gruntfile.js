module.exports = function(grunt) {
    // Chargement automatique de tous nos modules
    require('load-grunt-tasks')(grunt);

    // Configuration des plugins
    grunt.initConfig({
        bower: {
            install: {
                options: {
                    verbose: true,
                    targetDir: "bower_modules"
                }
            }
        },
        less: {
            dist: {
                options: {
                    compress: true,
                    yuicompress: true,
                    optimization: 3
                },
                files: {
                    ".tmp/css/main.css": [
                        "bower_modules/bootstrap/less/bootstrap.less",
                        "bower_modules/fontawesome/less/font-awesome.less",
                        "src/Manudev/CoreBundle/Resources/public/css/core.css",
                        "src/Manudev/UserBundle/Resources/public/css/user.css",
                        "src/Manudev/KDOBundle/Resources/public/css/kdo.css"
                    ]
                }
            }
        },
        cssmin: {
            combine: {
                options:{
                    report: 'min',
                        keepSpecialComments: 0
                },
                files: {
                    'web/css/main.css': [
                        '.tmp/css/**/*.css'
                    ]
                }
            }
        },

        uglify: {
            options: {
                mangle: false,
                sourceMap: true
            },
            dist: {
                files: {
                    'web/js/main.js': [
                        "bower_modules/bootstrap/js/affix.js",
                        "bower_modules/bootstrap/js/alert.js",
                        "bower_modules/bootstrap/js/button.js",
                        "bower_modules/bootstrap/js/carousel.js",
                        "bower_modules/bootstrap/js/collapse.js",
                        "bower_modules/bootstrap/js/dropdown.js",
                        "bower_modules/bootstrap/js/modal.js",
                        "bower_modules/bootstrap/js/tooltip.js",
                        "bower_modules/bootstrap/js/popover.js",
                        "bower_modules/bootstrap/js/scrollspy.js",
                        "bower_modules/bootstrap/js/tab.js",
                        "bower_modules/bootstrap/js/transition.js",

                        "src/Manudev/CoreBundle/Resources/public/js/core.js",
                        "src/Manudev/UserBundle/Resources/public/js/user.js",
                        "src/Manudev/KDOBundle/Resources/public/js/kdo.js"
                    ]
                }
            }
        },
        copy: {
            dist: {
                files: [{
                    expand: true,
                    cwd: 'bower_modules/fontawesome/fonts',
                    dest: 'web/fonts',
                    src: ['**']
                }]
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
    grunt.registerTask('default', ['css', 'javascript', 'copy']);
    grunt.registerTask('install', ['bower', 'preen']);
    grunt.registerTask('css', ['less','cssmin']);
    grunt.registerTask('javascript', ['uglify']);
    grunt.registerTask('cp', ['copy']);
};