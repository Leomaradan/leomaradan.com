copy ../share/.env .env
composer update
npm update
bower update
php artisan migrate
php artisan optimize