#!/usr/bin/env bash

# node.js settings
NODE_VERSION=0.10.29
NODE_SOURCE=http://nodejs.org/dist/v$NODE_VERSION/node-v$NODE_VERSION.tar.gz

# If apache2 does not exist
echo "INFO: Provisioning Wordpress Vagrant LAMP"

# Update apt-get
echo "INFO: Updating apt-get..."
apt-get update

# Install git
echo "INFO: Installing git..."
apt-get install -y git-core

# Install MySQL
echo "INFO: Installing mysql..."
echo "mysql-server-5.5 mysql-server/root_password password vagrant" | debconf-set-selections
echo "mysql-server-5.5 mysql-server/root_password_again password vagrant" | debconf-set-selections
apt-get install -y mysql-server

# Install apache2
echo "INFO: Installing apache2..."
apt-get install -y apache2
rm -rf /var/www
ln -fs /vagrant/site /var/www
echo "/var/www === /vagrant/site"

# Install PHP5
echo "INFO: Installing php5..."
apt-get install -y php5 libapache2-mod-php5 php-apc php5-mysql php5-dev

# Install OpenSSL
echo "INFO: Installing OpenSSL..."
apt-get install -y openssl

# If phpmyadmin does not exist
if [ ! -f /etc/phpmyadmin/config.inc.php ];
then
    # Used debconf-get-selections to find out what questions will be asked
    # This command needs debconf-utils

    # Handy for debugging. clear answers phpmyadmin: echo PURGE | debconf-communicate phpmyadmin

    echo "INFO: Installing phpmyadmin..."

    echo 'phpmyadmin phpmyadmin/dbconfig-install boolean false' | debconf-set-selections
    echo 'phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2' | debconf-set-selections

    echo 'phpmyadmin phpmyadmin/app-password-confirm password vagrant' | debconf-set-selections
    echo 'phpmyadmin phpmyadmin/mysql/admin-pass password vagrant' | debconf-set-selections
    echo 'phpmyadmin phpmyadmin/password-confirm password vagrant' | debconf-set-selections
    echo 'phpmyadmin phpmyadmin/setup-password password vagrant' | debconf-set-selections
    echo 'phpmyadmin phpmyadmin/database-type select mysql' | debconf-set-selections
    echo 'phpmyadmin phpmyadmin/mysql/app-pass password vagrant' | debconf-set-selections

    echo 'dbconfig-common dbconfig-common/mysql/app-pass password vagrant' | debconf-set-selections
    echo 'dbconfig-common dbconfig-common/mysql/app-pass password' | debconf-set-selections
    echo 'dbconfig-common dbconfig-common/password-confirm password vagrant' | debconf-set-selections
    echo 'dbconfig-common dbconfig-common/app-password-confirm password vagrant' | debconf-set-selections
    echo 'dbconfig-common dbconfig-common/app-password-confirm password vagrant' | debconf-set-selections
    echo 'dbconfig-common dbconfig-common/password-confirm password vagrant' | debconf-set-selections

    apt-get install -y phpmyadmin
fi

# Enable mod_rewrite
echo "INFO: Enabling mod_rewrite..."
a2enmod rewrite

# Enable SSL
echo "INFO: Enabling SSL..."
a2enmod ssl

# Update vhosts file
echo "INFO: Updating vhosts..."

VHOST=$(cat <<EOF
<VirtualHost *:80>
    DocumentRoot /var/www
    <Directory />
        Options FollowSymLinks
        AllowOverride All
    </Directory>
    <Directory /var/www>
        Options Indexes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        allow from all
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log

    # Possible values include: debug, info, notice, warn, error, crit,
    # alert, emerg.
    LogLevel warn

    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
EOF
)

echo "${VHOST}" > /etc/apache2/sites-available/default

# Restart services
echo "INFO: Restarting apache..."
/etc/init.d/apache2 restart

# Install node.js
echo "INFO: Installing node.js $NODE_VERSION..."
apt-get update
apt-get install -y python-software-properties python g++ make
add-apt-repository -y ppa:chris-lea/node.js
apt-get update
apt-get install -y nodejs

# Clean up apt-get
echo "INFO: Cleaning up apt-get..."
apt-get clean

# More to the /vagrant directory
cd /vagrant

# Install package.json dependencies
echo "INFO: Installing package.json..."
npm install

# Install Bundler
echo "INFO: Installing Bundler..."
gem install bundler

# Install gems
echo "INFO: Installing Ruby gems..."
bundle install

# Install bower
echo "INFO: Installing bower..."
npm install -g bower

# Install bower dependencies
echo "INFO: Installing bower dependencies..."
bower install --allow-root

# Install Grunt.js CLI
echo "INFO: Installing Grunt.js CLI..."
npm install -g grunt-cli

# build files
echo "INFO: Building assets..."
grunt build

echo "INFO: Provisioning Wordpress Vagrant LAMP complete!"
