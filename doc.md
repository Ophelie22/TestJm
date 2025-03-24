

Intalastion:
composer require nesbot/carbon


#Pour lancer les messages:

php bin/console messenger:consume insert_async -vvv


Pour nos Tests il faudra creer une bdd de tests:

php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:update --force --env=test
