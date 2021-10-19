init:
	cp .env.example .env && composer update && npm install && php artisan key:generate && php artisan migrate:fresh && php artisan passport:keys && php artisan passport:install


migratet:
	php artisan migrate:fresh


run:
	php artisan serve && npm run watch