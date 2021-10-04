# skyeng1-otus

app.local

```shell
cp .env.example .env
cp code/.env.example code/.env
docker-compose build
docker-compose up -d

docker-compose exec --user=1000:1000 php bash #1000 - user id & group id
#>>
cd /data
composer install
php artisan migrate
php artisan db:seed
ln -s vendor/swagger-api/swagger-ui/dist/ public/swagger-ui-assets
```

# Swagger
<host>/api/documentation - swagger
```shell
php artisan swagger-lume:publish # to publish everything - once after install swagger
php artisan swagger-lume:generate # to generate docs
```

Скопировать содержимое папки `/vendor/swagger-api/swagger-ui/dist/`  
в `public/swagger-ui-assets` (или сделать симлинк)