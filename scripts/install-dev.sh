#!/bin/bash

echo
echo "Deleting existing files -------------------------------------------------"
echo

unlink composer
unlink phpunit
rm -rf vendor

echo
echo "Installing Composer -----------------------------------------------------"
echo

EXPECTED_CHECKSUM="$(wget -q -O - https://composer.github.io/installer.sig)"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]
then
    >&2 echo 'ERROR: Invalid installer checksum'
    rm composer-setup.php
    exit 1
fi

php composer-setup.php --quiet
RESULT=$?

rm composer-setup.php
mv composer.phar composer
./composer --version


echo
echo "Installing PHPUnit ------------------------------------------------------"
echo

wget -O phpunit https://phar.phpunit.de/phpunit-7.phar
chmod +x phpunit
./phpunit --version

echo
echo "Running ./composer install ----------------------------------------------"
echo

./composer install

echo
echo "Done --------------------------------------------------------------------"
echo

exit $RESULT
