up:
	docker-compose up -d
	make cache_warmup

down:
	docker-compose down

restart: down up

init: up composer

update: down pull init

pull:
	git reset --HARD
	git pull origin master

composer:
	docker exec -it broadlink-api-php composer install

cache_warmup:
	docker exec -it broadlink-api-php php bin/console cache:warmup