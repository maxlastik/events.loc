Just Pet Project - Simple Events Ticketing System.

Installation:
1) git clone https://github.com/maxlastik/events.loc.git
2) copy .env.example .env
3) composer install
4) php artisan key:generate
5) php artisan storage:link
6) php artisan migrate:refresh --seed

---------------
Admin Account : admin@admin.ru / secret

Member Account: member@member.ru / secret

All emails (for account verification) will be placed in laravel.log file.
