# app-test-voyage

## Prérequis
- [Git][GitUrl]
- [Docker, Docker Compose][DockerUrl]

## Installation
#### 1. Clonage du dépôt
```sh
git clone https://github.com/kelgob/app-test-voyage.git
```

#### 2. Construction des containers
```sh
docker-compose up -d
```

#### 3. Connexion au container principal
```sh
docker exec -it php /bin/bash
```

#### 4. Installation des dépendances
```sh
composer install
``` 

#### 5. Migration et peuplement de la bdd
```sh
php bin/console doctrine:migration:migrate --no-interaction && php bin/console app:init-db
```

#### 6. Installation des assets et compilation
```sh
yarn install && yarn build
```

## Tests
```sh
php bin/phpunit
```

## Liens
Projet: http://localhost:8080/

(facultatif) PhpMyAdmin: http://localhost:8081/

[GitUrl]: <https://git-scm.com/>
[DockerUrl]: <https://www.docker.com/>