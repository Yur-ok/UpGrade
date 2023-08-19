up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose build

down-clear:
	docker-compose down -v --remove-orphans

env:
	docker-compose exec php-fpm cp -n .env.local.example .env.local
	docker-compose exec php-fpm cp -n .env.local.example .env.test.local

php-in:
	docker-compose exec php-fpm bash

composer-install:
	docker-compose exec php-fpm composer install

composer-req: ## add new package pack=new/pack
	docker-compose exec php-fpm composer require $(pack)

migration:
	docker-compose exec php-fpm php bin/console d:m:m --no-interaction

new-migration:
	docker-compose exec php-fpm php bin/console d:m:diff

fixture:
	docker-compose exec php-fpm php bin/console d:f:l --no-interaction --purge-with-truncate

recreate:
	docker-compose exec php-fpm php bin/console d:d:d --force
	docker-compose exec php-fpm php bin/console d:d:c
	docker-compose exec postgres psql -d limonad -f /docker-entrypoint-initdb.d/create_extension.sql
	docker-compose exec php-fpm php bin/console d:m:m --no-interaction
	docker-compose exec php-fpm php bin/console d:f:l --no-interaction --purge-exclusions=summaries_webmaster_rate --purge-with-truncate

test-clean-output:
	docker-compose exec php-fpm php bin/codecept clean

perm:
	sudo chown -R ${USER}:${USER} var
	sudo chown -R ${USER}:${USER} vendor
	sudo chown -R ${USER}:${USER} tests
	sudo chown -R ${USER}:${USER} .psalm