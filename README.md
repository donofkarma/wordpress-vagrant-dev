Wordpress Vagrant Starkers v0.1.0
====================

Baseline Wordpress and Starkers theme build using Vagrant.

Feel free to fork/clone/use it if you want to.


Included versions
---------------------

### Wordpress
- Wordpress v4.1.1
- Starkers v4.0


Installation
---------------------

To use this you will need:
- [Virtualbox](https://www.virtualbox.org/)
- [Vagrant](https://www.vagrantup.com/)
- Ruby (recommended)
- [Node.js](https://nodejs.org/) (recommended)
- [Bower](http://bower.io/) (recommended)
- [Grunt.js](http://gruntjs.com/) (recommended)

Once these have been installed clone the repo, `cd` into the directory, and start the provision by running:

```shell
vagrant up
```

This will create a full LAMP stack and install all the external dependencies for building the theme's assets.


### Database

To create the database navigate to [http://localhost:4567/phpmyadmin](http://localhost:4567/phpmyadmin) and log in with the username "root" and the password of "vagrant". Once you've added a new database for the Wordpress instance to use, remember to copy these setting over to the `site/wp-content/wp-config.php` file.

Now navigate to [http://localhost:4567](http://localhost:4567) to begin the Wordpress installation.


### Building assets

From the root of the repository run the grunt watch task to automatically compile the Sass and lint the JS when you make changes:

```shell
grunt watch
```

#### Available tasks

There are 4 build tasks included in the Gruntfile:

```shell
grunt (test|build|deploy)
```

1. test: lints the JS
2. build: compiles CSS and JS, and copies the images and fonts to the assets directory of the theme
3. deploy: runs the build task then minifies the CSS and JS
4. default: runs the test and then build tasks

#### NOTE
It is possible to run the entire project from within the Vagrant VM. Building the Sass and JS is noticeably slower but it means there are no other dependencies to install on the host machine.

In order to run the tasks you must run `vagrant ssh` to log in to the VM and then `cd /vagrant` into the root of the project. All of the tasks can be used as described above.


Release History
---------------------

- Add a better media query mixin
- Add image minification to deploy task


Release History
---------------------

For a full release history, see the [Changelog](https://github.com/donofkarma/wordpress-vagrant-starkers/blob/master/CHANGELOG.md)


License
---------------------

MIT: [https://github.com/donofkarma/wordpress-vagrant-starkers/blob/master/LICENSE-MIT](https://github.com/donofkarma/wordpress-vagrant-starkers/blob/master/LICENSE-MIT)
