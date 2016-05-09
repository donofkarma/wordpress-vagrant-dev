Wordpress Vagrant Starkers v1.0.0
====================

Baseline Wordpress and Starkers theme build using Vagrant.

Feel free to fork/clone/use it if you want to.


Included versions
---------------------

### Wordpress
- Wordpress (latest)
- Starkers v4.0


Installation
---------------------

To use this you will need:
- [Virtualbox](https://www.virtualbox.org/)
- [Vagrant](https://www.vagrantup.com/)
- [Node.js](https://nodejs.org/)

Once these have been installed clone the repo, `cd` into the directory, and start the provision by running:

```shell
vagrant up
```

Now, install the dependencies with:

```shell
npm install
```


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


To Do
---------------------


Release History
---------------------

For a full release history, see the [Changelog](https://github.com/donofkarma/wordpress-vagrant-starkers/blob/master/CHANGELOG.md)


License
---------------------

MIT: [https://github.com/donofkarma/wordpress-vagrant-starkers/blob/master/LICENSE-MIT](https://github.com/donofkarma/wordpress-vagrant-starkers/blob/master/LICENSE_MIT)
