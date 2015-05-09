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
                ]
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
            }
        },

        clean: {
            build: {
                src: ["web/assets", "web/palas"]
            }
        }
    });

    // Déclaration des différentes tâches
    grunt.registerTask('default', ['clean', 'copy', 'uglify']);
/*    grunt.registerTask('default', ['copy:dist', 'copy:src', 'css', 'javascript']);
    grunt.registerTask('css', ['copy:dist', 'copy:src', 'less','cssmin']);
    grunt.registerTask('javascript', ['copy:dist', 'copy:src', 'uglify']);*/
};

/*

 ,


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
 */
/*
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
 src: '** /*.css',
 dest: 'web/assets/css',
 ext: '.css'
 }
 ]
 }
 },
 */
/*

 copy: {
 src: {
 files: [
 {
 expand: true,
 cwd: 'src/Manudev/',
 dest: 'web/assets/src',
 */// src: ['**/Resources/public/js/**/*.js']
/*  },
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
 */