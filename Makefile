init: docker-clear docker-pull docker-build up ci

up:
	docker-compose up -d

down:
	docker-compose down --remove-orphans

docker-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

ci:
	docker-compose exec php-fpm composer install

key-generate:
	docker-compose exec php-fpm php artisan key:generate

bash:
	docker-compose exec php-fpm bash

test:
	docker-compose exec php-fpm vendor/bin/phpunit --colors=always




