#!/bin/bash -eu

export COMPOSER_ALLOW_SUPERUSER=1

dockerize -wait tcp://db:3306 -timeout 60s

GOSU="gosu webapp:webapp"
$GOSU symfony console doctrine:database:create --if-not-exists
$GOSU symfony console doctrine:migrations:migrate --no-interaction --allow-no-migration

if [ "${USE_DOCTRINE_FIXTURES:-0}" -eq "1" ]; then
  $GOSU symfony console doctrine:fixtures:load --no-interaction
fi

$GOSU symfony server:ca:install
exec supervisord -n -c /etc/supervisor/supervisord.conf