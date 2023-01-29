include .env
export

up: docker-up
down: docker-down
restart: docker-down docker-up
build: docker-build
init: docker-down docker-pull docker-build docker-up

#-----------------------------------------------------

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

#API#
api-composer-install:
	docker-compose run --rm api-php-fpm composer install

api-composer-require:
	docker-compose run --rm api-php-fpm composer require ${name}

api-composer-require-dev:
	docker-compose run --rm api-php-fpm composer require --dev ${name}

api-migrations-migrate:
	docker-compose run --rm api-php-fpm composer app migrations:migrate

api-migrations-migrate-prev:
	docker-compose run --rm api-php-fpm composer app migrations:migrate prev

api-migrations-diff:
	docker-compose run --rm api-php-fpm composer app migrations:diff