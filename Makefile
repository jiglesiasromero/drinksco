UID=$(shell id -u)
GID=$(shell id -g)
DOCKER_PHP_SERVICE=php-fpm

start: erase cache-folders build composer-install up

erase:
		docker-compose down -v

cache-folders:
		mkdir -p ~/.composer && chown ${UID}:${GID} ~/.composer

build:
		docker-compose build --no-cache && \
		docker-compose pull

composer-install:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} composer install

up:
		docker-compose up -d

stop:
		docker-compose stop

bash:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} sh

run-migrations:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} bin/console doctrine:migrations:execute -n --up 'DoctrineMigrations\Version20210728191731' && \
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} bin/console doctrine:migrations:execute -n --up 'DoctrineMigrations\Version20210729200625' && \
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} bin/console doctrine:migrations:execute -n --up 'DoctrineMigrations\Version20210730133440'

unit-tests:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} phpunit -c phpunit.xml

behat:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} behat

phpstan:
		docker-compose run --rm -u ${UID}:${GID} ${DOCKER_PHP_SERVICE} phpstan analyse src -l 2 -c phpstan.neon
