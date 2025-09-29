include ./compose.mk

start:
	php artisan serve --host 0.0.0.0

start-frontend:
	npm run dev

install: setup

setup:
	composer install
	cp -n .env.example .env
	php artisan key:gen --ansi
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed
	npm ci
	npm run build
	make ide-helper

watch:
	npm run watch

migrate:
	php artisan migrate

console:
	php artisan tinker

log:
	tail -f storage/logs/laravel.log

test:
	php artisan test

test-coverage:
	XDEBUG_MODE=coverage php artisan test --coverage-clover build/logs/clover.xml

lint:
	composer exec --verbose phpcs -- --standard=PSR12 app routes tests

ide-helper:
	php artisan ide-helper:eloquent
	php artisan ide-helper:gen
	php artisan ide-helper:meta
	php artisan ide-helper:mod -n