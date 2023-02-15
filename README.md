# Communited

## Staging

Entrée dans le répertoire principal.

```
cd staging
composer install
```

Préparation de la base de données.

```
symfony console doctrine:database:drop --force
symfony console doctrine:migrations:migrate
```

Exécution des tests.

```
vendor/bin/phpunit --group=functional
```
