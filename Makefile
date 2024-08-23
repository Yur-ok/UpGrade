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

# user команды
create-admin: ## make create-admin
	$(YII_CMD) user/create-admin $(name) $(pass) $(email)

create-user: ## make create-user name=name pass=password email=email
	$(YII_CMD) user/create-user $(name) $(pass) $(email)

# RBAC команды
rbac-init: rbac-migrations create-admin create-user create-first-roles
rbac-migrations:
	$(YII_CMD) migrate --migrationPath=@yii/rbac/migrations

create-first-roles:
	$(YII_CMD) rbac/init $(role)

create-role: ## make create-role role=admin
	$(YII_CMD) rbac/create-role $(role)

create-permission: ## make create-permission perm=createGoal desc="Allows user to create goals"
	$(YII_CMD) rbac/create-permission $(perm) $(desc)

rename-permission: ## make rename-permission old=createGoal new=createTask
	$(YII_CMD) rbac/rename-permission $(old) $(new)

add-permission-to-role:
	$(YII_CMD) rbac/add-permission-to-role $(role) $(perm)

assign-role-to-user:
	$(YII_CMD) rbac/assign-role $(role) $(user)

get-permissions-by-user:
	$(YII_CMD) rbac/get-permissions-by-user $(user)

list-roles-with-permissions:
	$(YII_CMD) rbac/list-roles-with-permissions

list-permissions:
	$(YII_CMD) rbac/list-permissions
