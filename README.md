WordPress Vagrant Baseline v1.2.1
====================

A WordPress development environment in Vagrant. Feel free to fork/clone/use it if you want to.


Installation
---------------------

### Prerequisites

To use this you will need:
- [Virtualbox](https://www.virtualbox.org/)
- [Vagrant](https://www.vagrantup.com/)
- [Node.js](https://nodejs.org/)


### Core Environment

Clone the repository, `cd` into the directory, and start the provision by running:

```shell
vagrant up
```

**Notes**
* DB credentials are _root_/_vagrant_
* WordPress admin credentials are _wp_dev_/_password_

### Images/CSS/JS

Install the dependencies and build the base assets with:

```shell
npm install && npm run build
```


#### Building assets

From the root of the repository run the watch task to automatically compile the Sass and JS (ES6) when you make changes:

```shell
npm run watch
```


Release History
---------------------

For a full release history, see the [Changelog](https://github.com/donofkarma/wordpress-vagrant-dev/blob/master/CHANGELOG.md)


License
---------------------

MIT: [https://github.com/donofkarma/wordpress-vagrant-dev/blob/master/LICENSE](https://github.com/donofkarma/wordpress-vagrant-dev/blob/master/LICENSE)


To-do
---------------------

* Add a more secure default password
