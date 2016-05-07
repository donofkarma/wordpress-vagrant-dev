#!/usr/bin/env bash

# If apache2 does not exist
echo "INFO: Provisioning WordPress Vagrant LAMP"

# Update apt-get
echo "INFO: Updating apt-get..."
apt-get update
echo "INFO: Updating apt-get... Done."

# Install git
echo "INFO: Installing git..."
apt-get install -y git-core
echo "INFO: Installing git... Done."

# Install Apache
echo "INFO: Installing apache2..."
apt-get install -y apache2
rm -rf /var/www
ln -fs /vagrant/site /var/www
echo "/var/www === /vagrant/site"
echo "INFO: Installing apache2... Done."

# Enable mod_rewrite
echo "INFO: Enabling mod_rewrite..."
a2enmod rewrite
echo "INFO: Enabling mod_rewrite... Done."

# Update vhosts file
echo "INFO: Updating vhosts..."
cp /vagrant/provision/vhosts-default.conf /etc/apache2/sites-available/default
echo "INFO: Updating vhosts... Done."

# Install PHP5
echo "INFO: Installing php5..."
apt-get install -y php5 libapache2-mod-php5 php-apc php5-mysql php5-dev
echo "INFO: Installing php5... Done."

# Install Composer if it is not yet available.
if [[ ! -n "$(composer --version --no-ansi | grep 'Composer version')" ]]; then
    echo "INFO: Installing Composer..."
    curl -sS "https://getcomposer.org/installer" | php
    chmod +x "composer.phar"
    mv "composer.phar" "/usr/local/bin/composer"
    echo "INFO: Installing Composer... Done"
fi

# Install MySQL
echo "INFO: Installing mysql..."
echo "mysql-server-5.5 mysql-server/root_password password vagrant" | debconf-set-selections
echo "mysql-server-5.5 mysql-server/root_password_again password vagrant" | debconf-set-selections
apt-get install -y mysql-server
echo "INFO: Installing mysql... Done."

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

    echo "INFO: Installing phpmyadmin... Done."

    echo "INFO: Setting up DB..."
    mysql -u "root" -p"vagrant" < "/vagrant/provision/db.sql"
    echo "INFO: Setting up DB... Done"
fi

mkdir /vagrant/tools

# Install Composer
if [[ ! -n "$(composer --version --no-ansi | grep 'Composer version')" ]]; then
    echo "INFO: Installing Composer..."

    curl -sS "https://getcomposer.org/installer" | php
    chmod +x "composer.phar"
    mv "composer.phar" "/usr/local/bin/composer"

    echo "INFO: Installing Composer... Done"
fi

# Install WP-CLI
if [[ ! -d "/vagrant/tools/wp-cli" ]]; then
    echo -e "INFO: Installing WP-CLI..."
    git clone "https://github.com/wp-cli/wp-cli.git" "/vagrant/tools/wp-cli"
    cd /vagrant/tools/wp-cli
    composer install
    # Link `wp` to the `/usr/local/bin` directory
    ln -sf "/vagrant/tools/wp-cli/bin/wp" "/usr/local/bin/wp"
    echo -e "INFO: Installing WP-CLI... Done"
fi

# Install and configure the latest stable version of WordPress
if [[ ! -d "/vagrant/site" ]]; then
    echo "INFO: Installing WordPress..."

    # Download and unzip files
    cd /vagrant
    curl -L -O "https://wordpress.org/latest.tar.gz"
    sudo -EH -u "vagrant" tar -xvf latest.tar.gz
    mv wordpress site
    rm latest.tar.gz
    cd /vagrant/site

    # Create a wp-config.php
    sudo -EH -u "vagrant" wp core config --dbname=wordpress_default --dbuser=root --dbpass=vagrant

    # Run the WordPress Installer
    sudo -EH -u "vagrant" wp core install --url=localhost:4567  --title="Local WordPress Dev" --admin_name=wp_dev --admin_email="admin@localhost.dev" --admin_password="password"

    echo "INFO: Installing WordPress... Done"
fi

# Restart services
echo "INFO: Restarting Apache..."
/etc/init.d/apache2 restart
echo "INFO: Restarting Apache... Done."

# Clean up apt-get
echo "INFO: Cleaning up apt-get..."
apt-get clean
echo "INFO: Cleaning up apt-get... Done."

echo "INFO: Provisioning WordPress Vagrant LAMP complete!"
