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

stan:
	docker-compose exec php-fpm php artisan code:analyse

sniff:
	docker-compose exec php-fpm ./vendor/bin/phpcs --error-severity=1 --warning-severity=8 --colors ./app; \
	docker-compose exec php-fpm ./vendor/bin/phpcs --error-severity=1 --warning-severity=8 --colors --report=summary ./app; return 0;

check-code: sniff test stan

perm:
	sudo chown ${USER}:${USER} bootstrap/cache -R
	sudo chown ${USER}:${USER} storage -R
	sudo chown ${USER}:${USER} storage/logs -R
	sudo chown ${USER}:${USER} app/ -R
	sudo chown ${USER}:${USER} config/ -R
	sudo chown ${USER}:${USER} database/ -R



