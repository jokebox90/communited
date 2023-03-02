#!/bin/bash -eux

export DATABASE_URL=null://null

chown -R webapp:webapp /webapp
chown -R webapp:webapp /usr/local/share/ca-certificates
chown -R webapp:webapp /etc/ssl/certs

GOSU="gosu webapp:webapp"

cd /webapp
$GOSU symfony composer install
$GOSU yarn install

exit 0