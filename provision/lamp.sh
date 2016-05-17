#!/usr/bin/env bash

# If apache2 does not exist
echo "INFO: Provisioning WordPress Vagrant LAMP"

# Update apt-get
echo "INFO: Updating apt-get..."
add-apt-repository ppa:ondrej/php
apt-get update
echo "INFO: Updating apt-get... Done."

# Install Apache
echo "INFO: Installing apache2..."
apt-get install -y apache2
echo "INFO: Installing apache2... Done."

# Enable mod_rewrite
echo "INFO: Enabling mod_rewrite..."
a2enmod rewrite
echo "INFO: Enabling mod_rewrite... Done."

# Update vhosts file
echo "INFO: Updating vhosts..."
cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf.old
cp /vagrant/provision/config/000-default.conf /etc/apache2/sites-available/000-default.conf
echo "INFO: Updating vhosts... Done."

# Install PHP5
echo "INFO: Installing php7..."
apt-get install -y php7.0 php7.0-mysql libapache2-mod-php7.0
echo "INFO: Installing php7... Done."

# Install MySQL
echo "INFO: Installing mysql..."
echo "mysql-server-5.5 mysql-server/root_password password vagrant" | debconf-set-selections
echo "mysql-server-5.5 mysql-server/root_password_again password vagrant" | debconf-set-selections
apt-get install -y mysql-server
echo "INFO: Installing mysql... Done."

echo "INFO: Creating WordPress DB..."
mysql -u "root" -p"vagrant" < "/vagrant/provision/config/db.sql"
echo "INFO: Creating WordPress DB... Done"

# # If phpmyadmin does not exist
# if [ ! -f /etc/phpmyadmin/config.inc.php ];
# then
#     # Used debconf-get-selections to find out what questions will be asked
#     # This command needs debconf-utils

#     # Handy for debugging. clear answers phpmyadmin: echo PURGE | debconf-communicate phpmyadmin

#     echo "INFO: Installing phpmyadmin..."

#     echo 'phpmyadmin phpmyadmin/dbconfig-install boolean false' | debconf-set-selections
#     echo 'phpmyadmin phpmyadmin/reconfigure-webserver multiselect apache2' | debconf-set-selections

#     echo 'phpmyadmin phpmyadmin/app-password-confirm password vagrant' | debconf-set-selections
#     echo 'phpmyadmin phpmyadmin/mysql/admin-pass password vagrant' | debconf-set-selections
#     echo 'phpmyadmin phpmyadmin/password-confirm password vagrant' | debconf-set-selections
#     echo 'phpmyadmin phpmyadmin/setup-password password vagrant' | debconf-set-selections
#     echo 'phpmyadmin phpmyadmin/database-type select mysql' | debconf-set-selections
#     echo 'phpmyadmin phpmyadmin/mysql/app-pass password vagrant' | debconf-set-selections

#     echo 'dbconfig-common dbconfig-common/mysql/app-pass password vagrant' | debconf-set-selections
#     echo 'dbconfig-common dbconfig-common/mysql/app-pass password' | debconf-set-selections
#     echo 'dbconfig-common dbconfig-common/password-confirm password vagrant' | debconf-set-selections
#     echo 'dbconfig-common dbconfig-common/app-password-confirm password vagrant' | debconf-set-selections
#     echo 'dbconfig-common dbconfig-common/app-password-confirm password vagrant' | debconf-set-selections
#     echo 'dbconfig-common dbconfig-common/password-confirm password vagrant' | debconf-set-selections

#     apt-get install -y phpmyadmin

#     echo "INFO: Installing phpmyadmin... Done."
# fi

# Install WP-CLI
if [[ ! -d "/vagrant/tools/wp-cli.phar" ]]; then
    echo -e "INFO: Installing WP-CLI..."

    mkdir /vagrant/tools
    cd /vagrant/tools
    curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
    chmod +x wp-cli.phar
    mv wp-cli.phar /usr/local/bin/wp

    echo -e "INFO: Installing WP-CLI... Done"
fi

# Install and configure the latest stable version of WordPress
if [[ ! -d "/vagrant/public_html" ]]; then
    echo "INFO: Installing WordPress..."

    # Download and unzip files
    cd /vagrant
    curl -L -O "https://wordpress.org/latest.tar.gz"
    sudo -EH -u "vagrant" tar -xvf latest.tar.gz
    mv wordpress public_html
    rm latest.tar.gz
    cd /vagrant/public_html

    # Create a wp-config.php
    sudo -EH -u "vagrant" wp core config --dbname=wordpress_default --dbuser=root --dbpass=vagrant

    # Run the WordPress Installer
    sudo -EH -u "vagrant" wp core install --url=localhost:4567 --title="Local WordPress Dev" --admin_name=wp_dev --admin_email="admin@localhost.dev" --admin_password="password"

    # Link our custom-theme and plugins directories
    ln -fs /vagrant/src/site/themes/custom-theme/ /vagrant/public_html/wp-content/themes/custom-theme
    rm -rf /vagrant/public_html/wp-content/plugins
    ln -fs /vagrant/src/site/plugins/ /vagrant/public_html/wp-content/plugins

    # Copy .htaccess file
    cp /vagrant/provision/config/.htaccess /vagrant/public_html/

    # Activate the Custom Theme
    sudo -EH -u "vagrant" wp theme activate custom-theme

    # Activate plugins
    # timber-library
    sudo -EH -u "vagrant" wp plugin activate timber-library

    # Update settings
    # permalinks
    sudo -EH -u "vagrant" wp rewrite structure '/%year%/%monthnum%/%postname%'

    echo "INFO: Installing WordPress... Done"
fi

# Symlinking public_html
echo "INFO: Symlinking public_html to /var/www/html..."
rm -rf /var/www/html
ln -fs /vagrant/public_html/ /var/www/html
echo "INFO: Symlinking public_html to /var/www/html... Done"

# Restart services
echo "INFO: Restarting Apache..."
/etc/init.d/apache2 restart
echo "INFO: Restarting Apache... Done."

# Clean up apt-get
echo "INFO: Cleaning up apt-get..."
apt-get clean
echo "INFO: Cleaning up apt-get... Done."

echo "INFO: Provisioning WordPress Vagrant LAMP complete!"
