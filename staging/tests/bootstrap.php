<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__) . '/config/bootstrap.php')) {
    require dirname(__DIR__) . '/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');
}

// Vide le cache Symfony.
passthru(sprintf(
    'APP_ENV=test php "%s/../bin/console" cache:clear --no-warmup',
    __DIR__
));


// Créé la base de données SQLite.
if (!file_exists(dirname(__DIR__) . sprintf('/var/test.db'))) {
    passthru(sprintf(
        'APP_ENV=test php "%s/../bin/console" doctrine:database:create --no-interaction  --verbose',
        __DIR__
    ));
}

// applique les migrations.
passthru(sprintf(
    'APP_ENV=test php "%s/../bin/console" doctrine:migrations:migrate --allow-no-migration --no-interaction  --verbose',
    __DIR__
));

// applique les fixtures.
passthru(sprintf(
    'APP_ENV=test php "%s/../bin/console" doctrine:fixtures:load --group=test --no-interaction  --verbose',
    __DIR__
));

echo sprintf(" [OK] Database '%s' ready.", $_ENV['BOOTSTRAP_DOCTRINE_DATABASE_CREATE']) . PHP_EOL . PHP_EOL;
