# skyeng1-otus

app.local

```shell
composer install

php artisan migrate
php artisan db:seed
```

<host>/api/documentation - swagger
```shell
php artisan swagger-lume:publish # to publish everything - once after install swagger
php artisan swagger-lume:generate # to generate docs
```

## run tests
```shell
# cd code
phpunit
```