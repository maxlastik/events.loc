Just Pet Project - Simple Events Ticketing System.

1) git clone https://github.com/maxlastik/events.loc.git
2) composer install
3) copy .env.example .env
4) php artisan key:generate
5) touch database/database.sqlite
6) php artisan storage:link
7) php artisan migrate:refresh --seed