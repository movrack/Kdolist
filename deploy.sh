#!/bin/bash

if [ "$1" == "dev" ]; then
    DEV=1
fi

cd /home/movrack/www/kdolist
echo `pwd`
git pull

if [ $DEV == "1" ]; then
        ./composer.phar install
        app/console cache:clear
        app/console assetic:dump
        app/console assets:install --symlink
        # app/console  doctrine:schema:drop
        app/console  doctrine:schema:update
        # app/console  doctrine:fixtures:load
else
        export SYMFONY_ENV=prod
        ./composer.phar install --no-dev --optimize-autoloader
        # app/console  doctrine:schema:drop --force --env=prod --no-debug
        app/console  doctrine:schema:update --env=prod --no-debug
        # app/console  doctrine:fixtures:load --env=prod --no-debug
        app/console assetic:dump --env=prod --no-debug
        app/console assets:install --env=prod --no-debug
        app/console cache:clear --env=prod --no-debug
        app/console cache:warmup --env=prod --no-debug
fi
