/*global module:false*/

module.exports = function(grunt) {
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        meta: {
            theme_dir: 'custom-theme',
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
                'src/js/script.js',
                'src/js/modules/*.js'
            ]
        },
        sass: {
            options: {
                sourcemap: 'none'
            },
            main: {
                files: {
                    'site/wp-content/themes/<%= meta.theme_dir %>/style.css': 'src/sass/style.scss',
                    'site/wp-content/themes/<%= meta.theme_dir %>/ie.css' : 'src/sass/ie.scss'
                }
            }
        },
        cssmin: {
            main: {
                options: {
                    banner: '<%= meta.css_banner %>'
                },
                files: {
                    'site/wp-content/themes/<%= meta.theme_dir %>/style.css': ['site/wp-content/themes/<%= meta.theme_dir %>/style.css'],
                    'site/wp-content/themes/<%= meta.theme_dir %>/ie.css': ['site/wp-content/themes/<%= meta.theme_dir %>/ie.css']
                }
            }
        },
        uglify: {
            options: {
                mangle: {
                    except: ['jQuery']
                }
            },
            libraries: {
                files: {
                    'site/wp-content/themes/<%= meta.theme_dir %>/assets/js/libs.js': [
                        'bower_components/jquery/dist/jquery.min.js'
                    ]
                }
            },
            develop: {
                options: {
                    mangle: false
                },
                files: {
                    'site/wp-content/themes/<%= meta.theme_dir %>/assets/js/script.js': [
                        'src/js/script.js',
                        'src/js/modules/*.js'
                    ]
                }
            },
            deploy: {
                files: {
                    'site/wp-content/themes/<%= meta.theme_dir %>/assets/js/script.js': [
                        'src/js/script.js',
                        'src/js/modules/*.js'
                    ]
                }
            },
        },
        clean: {
            fonts: {
                src: ['site/wp-content/themes/<%= meta.theme_dir %>/assets/fonts/*']
            },
            images: {
                src: ['site/wp-content/themes/<%= meta.theme_dir %>/assets/images/*']
            },
            script: {
                src: ['site/wp-content/themes/<%= meta.theme_dir %>/assets/js/*']
            },
        },
        copy: {
            fonts: {
                files: [
                    {
                        expand: true,
                        cwd: 'src/fonts/',
                        src: ['**'],
                        dest: 'site/wp-content/themes/<%= meta.theme_dir %>/assets/fonts/'
                    }
                ]
            },
            images: {
                files: [
                    {
                        expand: true,
                        cwd: 'src/images/public/',
                        src: ['**'],
                        dest: 'site/wp-content/themes/<%= meta.theme_dir %>/assets/images/'
                    }
                ]
            }
        },
        watch: {
            fonts: {
                files: ['src/fonts/**/*.*'],
                tasks: ['clean:fonts', 'copy:fonts']
            },
            images: {
                files: ['src/images/public/**/*.*'],
                tasks: ['clean:images', 'copy:images']
            },
            sass: {
                files: ['src/sass/**/*.scss'],
                tasks: ['sass', 'cssmin']
            },
            script: {
                files: '<%= jshint.all %>',
                tasks: ['jshint', 'uglify:develop']
            }
        }
    });

    // Load tasks
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-sass');

    // // Default task(s)
    grunt.registerTask('test', ['jshint']);
    grunt.registerTask('build', ['clean', 'copy', 'sass', 'cssmin', 'uglify:libraries', 'uglify:develop']);
    grunt.registerTask('deploy', ['build', 'uglify:deploy']);
    grunt.registerTask('default', ['test', 'build']);
};
