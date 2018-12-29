#---------------------------
# Docker controls
#---------------------------

up:
	docker-compose up -d

down:
	docker-compose down

s:
	docker-compose ps

build:
	docker-compose up -d --build

rebuild:
	docker-compose build --no-cache

remove-volumes:
	docker-compose down --volumes

#---------------------------
# Application
#---------------------------

migrate:
	docker-compose exec php-cli php artisan migrate

seed:
	docker-compose exec php-cli php artisan db:seed

refresh:
	docker-compose exec php-cli php artisan migrate:refresh

tinker:
	docker-compose exec php-cli php artisan tinker

test:
	@docker-compose exec php-cli vendor/bin/phpunit

autoload:
	docker-compose exec php-cli composer du

perm:
	sudo chown ${USER}:${USER} bootstrap/cache storage app/ database/ resources/ tests/ -R
	sudo chmod -R 777 bootstrap/cache
	sudo chmod -R 777 storage

#---------------------------
# Front-end
#---------------------------

assets:
	docker-compose exec node yarn install

watch:
	docker-compose exec node yarn watch
