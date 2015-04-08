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
                    ".tmp/css/main.css": [
                        "src/Manudev/CoreBundle/Resources/public/bower/bootstrap/less/bootstrap.less",
                        "src/Manudev/CoreBundle/Resources/public/bower/fontawesome/less/font-awesome.less",
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
                        "src/Manudev/CoreBundle/Resources/public/bower/bootstrap/js/affix.js",
                        "src/Manudev/CoreBundle/Resources/public/bower/bootstrap/js/alert.js",
                        "src/Manudev/CoreBundle/Resources/public/bower/bootstrap/js/button.js",
                        "src/Manudev/CoreBundle/Resources/public/bower/bootstrap/js/carousel.js",
                        "src/Manudev/CoreBundle/Resources/public/bower/bootstrap/js/collapse.js",
                        "src/Manudev/CoreBundle/Resources/public/bower/bootstrap/js/dropdown.js",
                        "src/Manudev/CoreBundle/Resources/public/bower/bootstrap/js/modal.js",
                        "src/Manudev/CoreBundle/Resources/public/bower/bootstrap/js/tooltip.js",
                        "src/Manudev/CoreBundle/Resources/public/bower/bootstrap/js/popover.js",
                        "src/Manudev/CoreBundle/Resources/public/bower/bootstrap/js/scrollspy.js",
                        "src/Manudev/CoreBundle/Resources/public/bower/bootstrap/js/tab.js",
                        "src/Manudev/CoreBundle/Resources/public/bower/bootstrap/js/transition.js",

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
                    cwd: 'src/Manudev/CoreBundle/Resources/public/bower/fontawesome/fonts',
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
    grunt.registerTask('css', ['less','cssmin']);
    grunt.registerTask('javascript', ['uglify']);
    grunt.registerTask('cp', ['copy']);
};