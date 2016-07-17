Changelog
---------------------

### 1.2.1
- .htaccess update
- Making sure mod_deflate is turned on

### 1.2.0
- Adding sendmail for email capability
- Adding phpMyAdmin for easy DB editing

### 1.1.0
- Moving to Twig templating via the Timber plugin
- Adding HTML and CSS structure to templates for easier start
- Fixing `<title>` tag display
- Adding OpenGraph meta data

### 1.0.0
Complete re-write of the core:
- Updating Vagrant box to ubuntu/trusty64
- Turning on NFS for better performance
- New provisioning to create the instance for you on first `vagrant up`
- Upgrading to PHP 7

### 0.2.0
- Upgrading to Wordpress 4.4.2
- Adding .htaccess file
- Updating SASS layout
- Switching to ES6
- Changing build from Grunt to npm scripts
- Removing jQuery

### 0.1.1
- Removing auto build on `vagrant up` due to failing GETs
- Removing Ruby Sass dependancy in favour of libsass
- Removing jquery.hammer from bower.json
- Updating `<html>` conditional comments

### 0.1.0
- Updating `vagrant up` to include building dependencies on first load
- Adding Gemfile and bower.json to handle additional dependencies

### 0.0.1
- Adding initial code
