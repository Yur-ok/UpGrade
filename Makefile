up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose build

down-clear:
	docker-compose down -v --remove-orphans

yii-init:
	docker-compose run --rm php-fpm composer create-project --prefer-dist yiisoft/yii2-app-basic .

env:
	docker-compose exec php-fpm cp -n .env.local.example .env.local
	docker-compose exec php-fpm cp -n .env.local.example .env.test.local

php-cli:
	docker-compose exec php-fpm bash

composer-install:
	docker-compose exec php-fpm composer install

composer-req: ## add new package pack=new/pack
	docker-compose exec php-fpm composer require $(pack)

