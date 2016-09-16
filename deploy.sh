#!/bin/bash
foldername=$(date +%Y%m%d%H%M%S)

# 1 down mode
php artisan down

cd ..

# 2 get latest version
git clone https://github.com/Leomaradan/leomaradan.com.git releases/"$foldername"

# link .env
ln -s share/.env releases/"$foldername"/.env

cd releases/"$foldername"

# 4 update dependencies
composer update
npm update
bower update

cd ../../

# 5 link uploads
ln -s share/uploads releases/"$foldername"/public/uploads

# 6 replace current version
ln -fs releases/"$foldername" current

cd current

# 7 migrate & optimize autoloader & launch application
php artisan migrate
php artisan optimize
php artisan up