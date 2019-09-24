#!/bin/bash
export VERSION="$(ls -lR /home/edenn/Symfony/Edenn/atypikhouseCP21/*.zip | wc -l)"
export LOCATION="/home/edenn/Symfony/Edenn/atypikhouseCP21/${VERSION}"
git clone https://github.com/deozza/atypikhouseCP21 "/home/edenn/Symfony/Edenn/atypikhouseCP21/${VERSION}"
git checkout origin/prod --track
cd "/home/edenn/Symfony/Edenn/atypikhouseCP21/${VERSION}"
cp .env.dist .env
echo -e "\nDATABASE_URL=mysql://root@127.0.0.1:3306/AtypikHouse" >> .env
echo -e "\nMAILER_URL=null://localhost" >> .env
echo -e "\nDB_MANAGER=mysql" >> .env
composer install
cd ../
zip -r "${LOCATION}.zip" "${LOCATION}"