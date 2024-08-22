# Основные переменные
PHP_FPM=docker-compose run --rm php-fpm
YII_CMD=$(PHP_FPM) php yii


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

# RBAC команды
create-role: ## make create-role role=admin
	$(YII_CMD) rbac/create-role $(role)

create-permission: ## make create-permission perm=createGoal desc="Allows user to create goals"
	$(YII_CMD) rbac/create-permission $(perm) $(desc)

rename-permission: ## make rename-permission old=createGoal new=createTask
	$(YII_CMD) rbac/rename-permission $(old) $(new)

add-permission-to-role:
	$(YII_CMD) rbac/add-permission-to-role $(role) $(perm)

get-permissions-by-user:
	$(YII_CMD) rbac/get-permissions-by-user $(user)

list-roles-with-permissions:
	$(YII_CMD) rbac/list-roles-with-permissions

list-permissions:
	$(YII_CMD) rbac/list-permissions
