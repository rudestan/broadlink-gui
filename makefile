up:
	docker-compose up -d
	make composer

down:
	docker-compose down

restart: down up

init:
	docker-compose build --force-rm --no-cache
	make up

update: down pull init

pull:
	git reset --hard
	git pull origin master

composer:
	docker exec -it broadlink-api-php composer install

cache_warmup:
	docker exec -it broadlink-api-php php bin/console cache:clear
	docker exec -it broadlink-api-php php bin/console cache:warmup
	docker exec -w /var/www -it broadlink-api-php chown -R www-data:1000 var
	docker exec -w /var/www -it broadlink-api-php chmod -R 777 var

composer_update:
	docker exec -it broadlink-api-php composer update

cli:
	docker exec -it broadlink-api-php sh