init: docker-down docker-pull docker-build docker-up api-composer-install api-migration-start
down: docker-down
up: docker-up

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

api-composer-install:
	docker-compose run --rm api-php-cli composer install

api-migration-start:
	docker-compose run --rm api-php-cli php bin/console doctrine:migrations:migrate