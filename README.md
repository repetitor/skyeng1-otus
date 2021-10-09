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

cd /data/console
php console.php student_task_rate & php console.php student_aggregation_tasks_skills & php console.php student_aggregation_time_today & php console.php student_aggregation_time_month & php console.php student_aggregation_courses
```

## Swagger
<host>/api/documentation - swagger
```shell
php artisan swagger-lume:publish # to publish everything - once after install swagger
php artisan swagger-lume:generate # to generate docs
```

Скопировать содержимое папки `/vendor/swagger-api/swagger-ui/dist/`  
в `public/swagger-ui-assets` (или сделать симлинк)



## RabbitMQ's consumer:
Open PHP docker by cli: docker-compose exec php bash

Need change directory: cd /data/console

Run command: php console.php student_task_rate & php console.php student_aggregation_tasks_skills & php console.php student_aggregation_time_today & php console.php student_aggregation_time_month & php console.php student_aggregation_courses
  
## run tests
```shell
# cd code
phpunit
```
