#!/bin/bash

export SYMFONY_ENV=prod
cd /home/movrack/www/kdolist
git pull
composer install --no-dev --optimize-autoloader
app/console cache:clear --env=prod --no-debug
app/console assetic:dump --env=prod --no-debug
app/console assets:install --symlink --env=prod --no-debug
# app/console  doctrine:schema:drop --force --env=prod --no-debug
app/console  doctrine:schema:update --env=prod --no-debug
# app/console  doctrine:fixtures:load --env=prod --no-debug
