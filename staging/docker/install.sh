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
    supervisor \
    wget

apt-get autoclean
apt-get clean
rm -rf /var/lib/apt/lists/*
rm -rf /var/cache/apt/*

docker-php-ext-configure zip
docker-php-ext-install -j$(nproc) zip
docker-php-ext-configure pdo_mysql
docker-php-ext-install -j$(nproc) pdo_mysql

pecl install redis
docker-php-ext-enable redis

pecl install xdebug
docker-php-ext-enable xdebug

echo 'xdebug.start_with_request=yes' | tee -a $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini

npm install -g npm
npm install -g yarn

wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

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

exit 0