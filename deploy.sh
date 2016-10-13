#!/bin/bash
foldername=$(date +%Y%m%d%H%M%S)

# 1 down mode
php artisan down

mv .env ../share/
mv public/uploads ../share/
mv node_modules ../share/

cd ..

# 2 get latest version
git clone https://github.com/Leomaradan/leomaradan.com.git releases/"$foldername"

mv share/.env releases/"$foldername"/
mv share/public/uploads releases/"$foldername"/public/
mv share/node_modules releases/"$foldername"/

cd releases/"$foldername"

# 4 update dependencies
composer update
npm update
bower update

cd ../../

# 5 link uploads
ln -Fs share/uploads releases/"$foldername"/public/uploads

# 6 replace current version
unlink current
ln -Fs releases/"$foldername" current

cd current

# 7 permissions
chmod -R 777 storage

# 7 migrate & optimize autoloader & launch application
php artisan migrate
php artisan cache:clear
php artisan optimize
php artisan up