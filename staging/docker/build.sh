#!/bin/bash -eux

export DATABASE_URL=null://null

chown -R webapp:webapp /webapp
GOSU="gosu webapp:webapp"
# $GOSU symfony new --dir=/webapp/app --no-git --version=${SYMFONY_INSTALL_VERSION}

cd /webapp
$GOSU symfony composer install
$GOSU yarn install

exit 0