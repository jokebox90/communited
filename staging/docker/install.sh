#!/bin/bash -eux

apt-get update
curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash -
curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
apt-get update
apt-get install -y --no-install-recommends --no-install-suggests \
    symfony-cli \
    git \
    gosu \
    libzip-dev \
    zip \
    unzip \
    bzip2 \
    libmariadb-dev \
    libmariadb-dev-compat \
    nodejs \
    supervisor

docker-php-ext-configure zip
docker-php-ext-install -j$(nproc) zip
docker-php-ext-configure pdo_mysql
docker-php-ext-install -j$(nproc) pdo_mysql

pecl install redis
docker-php-ext-enable redis

pecl install xdebug
docker-php-ext-enable xdebug

echo 'xdebug.mode=debug' | tee -a $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini
echo 'xdebug.start_with_request=yes' | tee -a $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini

npm install -g npm
npm install -g yarn

addgroup \
    --system \
    --gid 1000 \
    webapp

adduser \
    --system \
    --uid 1000 \
    --gid 1000 \
    --home /webapp \
    --shell /bin/bash \
    --disabled-password \
    webapp

chown -R webapp:webapp /webapp

exit 0