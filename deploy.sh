#!/bin/sh
dir=$(dirname $0)
$dir/bin/console doctrine:database:drop --force
$dir/bin/console doctrine:database:create
$dir/bin/console doctrine:schema:create
$dir/bin/console doctrine:migrations:version --add --all -n
$dir/bin/console doctrine:fixtures:load -n