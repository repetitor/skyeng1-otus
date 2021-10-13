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

#ln -s vendor/swagger-api/swagger-ui/dist/ public/swagger-ui-assets
cp -r vendor/swagger-api/swagger-ui/dist/ public/swagger-ui-assets

cd /data/console
php console.php student_task_rate & \
php console.php student_aggregation_tasks_skills & \
php console.php student_aggregation_time_today & \
php console.php student_aggregation_time_month & \
php console.php student_aggregation_courses & \
php console.php student_receive_awards &
```

## Swagger
<host>/api/documentation - swagger
```shell
php artisan swagger-lume:publish # to publish everything - once after install swagger
php artisan swagger-lume:generate # to generate docs
```
Скопировать содержимое папки `/vendor/swagger-api/swagger-ui/dist/`  
в `public/swagger-ui-assets` (или сделать симлинк)
  
## run tests
```shell
# cd code
phpunit
```



### Проектная работа выполнена для курса "[PHP Developer. Professional](https://otus.ru/lessons/razrabotchik-php/)"