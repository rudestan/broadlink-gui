up:
	docker-compose up -d

down:
	docker-compose down

restart: down up

init: up composer

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
