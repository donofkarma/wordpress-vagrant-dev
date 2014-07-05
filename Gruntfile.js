/*global module:false*/

module.exports = function(grunt) {
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        meta: {
            css_banner: '/*\n' +
                'Theme Name: Custom Theme\n' +
                'Theme URI: http://[YOUR URL]/\n' +
                'Author: <%= pkg.author %>\n' +
                'Description: <%= pkg.description %>\n' +
                'Version: <%= pkg.version %>\n' +
                'License: <%= pkg.licenses[0].type %>\n' +
                'License URI: <%= pkg.licenses[0].url %>\n' +
                '*/\n'
        },
        jshint: {
            options: {
                curly: true,
                eqeqeq: true,
                immed: true,
                latedef: true,
                newcap: true,
                noarg: true,
                sub: true,
                undef: true,
                boss: true,
                eqnull: true,
                browser: true,
                globals: {
                    // jQuery
                    jQuery: true,
                    // extras
                    alert: true,
                    console: true
                }
            },
            all: [
                'Gruntfile.js',
                'assets/js/*.js',
            ]
        },
        sass: {
            main: {
                files: {
                    'site/wp-content/themes/custom-theme/style.css': 'assets/sass/style.scss',
                    'site/wp-content/themes/custom-theme/ie.css' : 'assets/sass/ie.scss'
                }
            }
        },
        cssmin: {
            main: {
                options: {
                    banner: '<%= meta.css_banner %>'
                },
                files: {
                    'site/wp-content/themes/custom-theme/style.css': ['site/wp-content/themes/custom-theme/style.css'],
                    'site/wp-content/themes/custom-theme/ie.css': ['site/wp-content/themes/custom-theme/ie.css']
                }
            }
        },
        uglify: {
            options: {
                mangle: {
                    except: ['jQuery']
                }
            },
            deploy: {
                files: {
                    'site/wp-content/themes/custom-theme/assets/js/libs.js': ['assets/js/libs/**/*.js'],
                    'site/wp-content/themes/custom-theme/assets/js/script.js': ['assets/js/script.js']
                }
            }
        },
        copy: {
            // fonts: {
            //     files: [
            //         {
            //             expand: true,
            //             cwd: 'assets/fonts/',
            //             src: ['**'],
            //             dest: 'site/wp-content/themes/custom-theme/assets/fonts/'
            //         }
            //     ]
            // },
            images: {
                files: [
                    {
                        expand: true,
                        cwd: 'assets/images/public/',
                        src: ['**'],
                        dest: 'site/wp-content/themes/custom-theme/assets/images/'
                    }
                ]
            }
        },
        watch: {
            sass: {
                files: ['assets/sass/**/*.scss'],
                tasks: ['sass', 'cssmin']
            },
            lint: {
                files: '<%= jshint.all %>',
                tasks: 'jshint'
            }
        }
    });

    // Load tasks
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // // Default task(s)
    grunt.registerTask('test', ['jshint']);
    grunt.registerTask('build', ['sass', 'cssmin', 'uglify', 'copy']);
    grunt.registerTask('default', ['test', 'build']);
};
