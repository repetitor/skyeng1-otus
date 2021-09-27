# skyeng1-otus

app.local

```
composer install

php artisan migrate
php artisan db:seed
```


если хотите уже все сходу пробовать, можно через ларадок все автоматом поднять:

1. куда-нибудь клонируете ларадок, можно не в проект:
```
git clone https://github.com/laradock/laradock.git
```
2. копируете туда файлик
```
cp laradock/env-laradock-example <path-to-laradock>/.env
```
3. в сам проект копируете 
```
cp laradock/env-code code/.env
```
4. поднимаете докер-контэйнеры
```
cd <path-to-laradock>

docker-compose up -d nginx postgres
```
5. поднимаете базу
```
docker-compose exec --user=laradock workspace bash
```
запускаете команды из README.md:
```
php artisan migrate
php artisan db:seed
```
6. ну и в браузере давно уже можно набирать localhost:83


