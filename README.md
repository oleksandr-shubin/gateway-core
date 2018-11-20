# gateway-core


1. ```composer install```
2. Setting .env:
    1. ```cp .env.example .env```
    2. ```php artisan key:generate```
    3. amend as required .env properties (not limited to):
        1.  DB_CONNECTION
        2. DB_DATABASE
        3. DB_USERNAME
        4. DB_PASSWORD
3. Run migrations: ```php artisan migrate```
4. Setting .env.testing:
    1. ```cp .env.example .env.testing```
    2. ```php artisan key:generate --env=testing```
    3. see point 2.iii
5. Run migrations: ```php artisan migrate --env=testing```
4. Run tests: ```./vendor/bin/phpunit```