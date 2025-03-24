# Installation

```bash
composer install
composer require nesbot/carbon
composer require friendsofsymfony/elastica-bundle
```

# Lancement du projet

```bash
docker-compose up
```

# Pour lancer les messages

```bash
php bin/console messenger:consume insert_async -vvv
```

# Création de la base de données de tests

```bash
php bin/console doctrine:database:create --env=test
php bin/console doctrine:schema:update --force --env=test
php bin/console messenger:consume insert_async -vvv
```
# Lancer las commandes suivantes pour scrapper les donnes en json:
```bash
php bin/console app:scrap:linkedin
php bin/console app:scrap:jean-paul
```
# Puis on va ccreer l'index de Elastic Search
```bash
php bin/console app:freelance:index
php bin/console app:consolidate:freelance

```



# Commandes FOS Elastica

```bash
php bin/console fos:elastica:create  # Creating empty index with mapping
php bin/console fos:elastica:delete  # Deleting an index
php bin/console fos:elastica:populate  # Populates search indexes from providers
php bin/console fos:elastica:reset  # Reset search indexes
php bin/console fos:elastica:reset-templates  # Reset search indexes templates
php bin/console fos:elastica:search  # Searches documents in a given type and index
```

# Configuration de `fos_elastica.yaml`

Ajoute ou ajuste les propriétés dans le fichier `fos_elastica.yaml` pour refléter les champs de ton entité `FreelanceConso` :

```yaml
fos_elastica:
    clients:
        default:
            url: '%env(ELASTICSEARCH_URL)%' # Utilise l'URL définie dans .env ou .env.test
    indexes:
        freelance:
            persistence:
                driver: orm
                model: App\Entity\FreelanceConso
                provider: ~
                finder: ~
            properties:
                id:
                    type: integer
                firstName:
                    type: text
                    analyzer: standard
                lastName:
                    type: text
                    analyzer: standard
                jobTitle:
                    type: text
                    analyzer: standard
                linkedInUrl:
                    type: keyword
                fullName:
                    type: text
                    analyzer: standard
```

# Création de l'index Elasticsearch

```bash
php bin/console fos:elastica:populate
```

# Vérification de l'index

```bash
curl http://test-technique-broken-elasticsearch-1:9200/freelance/_mapping
curl http://test-technique-broken-elasticsearch-1:9200/freelance/_search
```

# Test fonctionnel

```bash
php bin/phpunit --filter testEnvDocker
```

# Installation du kernel Symfony

```bash
composer require symfony/http-kernel
```

# Notes supplémentaires

- L'indexation peut être effectuée manuellement en supprimant la section `persistence` dans `fos_elastica.yaml`.
- Assure-toi que ton `.env.test` est bien configuré avec le bon nom de conteneur Docker Elasticsearch.

# Création de la base de données

```bash
docker compose exec php bin/console doctrine:database:create
```

# Lancement des migrations

```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate --no-interaction
```

# Suppression de la base de données

```bash
php bin/console doctrine:database:drop --force
```

# Commandes spécifiques

## Lancer la commande de scraping LinkedIn

```bash
php bin/console app:scrap:linkedin
```

## Lancer la recherche de freelances

```bash
http://localhost:8000/freelances
http://localhost:8000/freelances/search?query=Symfony
```

## Tester Elasticsearch

```bash
curl -X GET 'http://elasticsearch:9200/freelance/_search?pretty=true' \
-H 'Content-Type: application/json' \
-d '{ "query": { "match": { "jobTitle": "Consultant IT" } } }'
```

## Indexation manuelle

```bash
php bin/console app:consolidate:freelance
php bin/console app:freelance:index
php bin/console fos:elastica:populate
php bin/console debug:router status_up
```

# Tests

```bash
php bin/phpunit --filter TechnicalTest::testEnvDocker
php bin/phpunit --filter TechnicalTest::testImportLinkedIn
php bin/phpunit --filter TechnicalTest::testImportJeanPaul
php bin/phpunit --filter TechnicalTest::testNormalizeFreelance
php bin/phpunit --filter testElasticSearchBasicSearch --testdox
php bin/phpunit --filter testElasticSearchBasicSearchWithSerializer
php bin/phpunit --filter testConnector
php bin/phpunit --filter testFindFirstName
```

# Installation du kernel Symfony

```bash
composer require symfony/http-kernel
```

