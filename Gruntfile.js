module.exports = function(grunt) {
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        meta: {
            theme_dir: 'custom-theme'
        },
        clean: {
            fonts: {
                src: ['site/wp-content/themes/<%= meta.theme_dir %>/assets/fonts']
            },
            images: {
                src: ['site/wp-content/themes/<%= meta.theme_dir %>/assets/images']
            },
            style: {
                src: ['site/wp-content/themes/<%= meta.theme_dir %>/assets/css']
            },
            script: {
                src: ['site/wp-content/themes/<%= meta.theme_dir %>/assets/js']
            }
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
            },
            'script_admin': {
                files: [
                    {
                        expand: true,
                        cwd: 'src/js/admin-utils/',
                        src: ['**'],
                        dest: 'site/wp-content/themes/<%= meta.theme_dir %>/assets/js/admin-utils/'
                    }
                ]
            }
        },
        sass: {
            main: {
                files: {
                    'site/wp-content/themes/<%= meta.theme_dir %>/assets/css/style.css': 'src/sass/style.scss'
                }
            }
        },
        cssmin: {
            main: {
                files: {
                    'site/wp-content/themes/<%= meta.theme_dir %>/assets/css/style.css': ['site/wp-content/themes/<%= meta.theme_dir %>/assets/css/style.css']
                }
            }
        },
        jshint: {
            options: {
                jshintrc: './.jshintrc'
            },
            main: ['src/js/**/*.js']
        },
        browserify: {
            main: {
                files: {
                    'site/wp-content/themes/<%= meta.theme_dir %>/assets/js/script.js': ['src/js/script.js'],
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
                    'site/wp-content/themes/<%= meta.theme_dir %>/assets/js/script.js': ['site/wp-content/themes/<%= meta.theme_dir %>/assets/js/script.js']
                }
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
                tasks: ['sass']
            },
            script: {
                files: ['src/js/**/*.*', '!src/js/admin-utils/**/*.*'],
                tasks: ['jshint', 'browserify']
            }
        }
    });

    // Load tasks
    require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

    // // Default task(s)
    grunt.registerTask('test', ['jshint']);
    grunt.registerTask('build', ['clean', 'copy', 'sass', 'browserify']);
    grunt.registerTask('deploy', ['test', 'build', 'cssmin', 'uglify']);
    grunt.registerTask('default', ['build', 'watch']);
};
