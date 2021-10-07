<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([
            'title' => 'Тема 1. Подготовка к курсу и инфраструктура ПО',
            'module_id' => '1',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 2. Linux',
            'module_id' => '1',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 3. Основы PHP. Консольный PHP',
            'module_id' => '1',
        ]);

        DB::table('tasks')->insert([
            'title' => 'Тема 7. Основные понятия баз данных',
            'module_id' => '2',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 8. PostgreSQL для администратора',
            'module_id' => '2',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 9. PostgreSQL для разработчика',
            'module_id' => '2',
        ]);

        DB::table('tasks')->insert([
            'title' => 'Тема 15. Парадигмы программирования',
            'module_id' => '3',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 16. Архитектура кода',
            'module_id' => '3',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 17. Design patterns. Часть 1',
            'module_id' => '3',
        ]);


        DB::table('tasks')->insert([
            'title' => 'Тема 1. Введение в курс',
            'module_id' => '4',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 2. Git',
            'module_id' => '4',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 3. Основы HTML / CSS. часть 1',
            'module_id' => '4',
        ]);

        DB::table('tasks')->insert([
            'title' => 'Тема 7. Базы данных',
            'module_id' => '5',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 8. SQL',
            'module_id' => '5',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 9. Транзакции',
            'module_id' => '5',
        ]);


        DB::table('tasks')->insert([
            'title' => 'Тема 11. Введение и базовые понятия',
            'module_id' => '6',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 12. Переменные, типы',
            'module_id' => '6',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 13. Ветвления',
            'module_id' => '6',
        ]);


        DB::table('tasks')->insert([
            'title' => 'Тема 1. Установка и «Hello, world»',
            'module_id' => '7',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 2. Фронтэнд',
            'module_id' => '7',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 3. Хранилище для Laravel-продукта',
            'module_id' => '7',
        ]);


        DB::table('tasks')->insert([
            'title' => 'Тема 10. Логирование и полезные функции фреймворка',
            'module_id' => '8',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 11. Middleware',
            'module_id' => '8',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 12. Кэширование',
            'module_id' => '8',
        ]);


        DB::table('tasks')->insert([
            'title' => 'Тема 17. Контракты и фасады',
            'module_id' => '9',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 18. Envoy и развёртывание',
            'module_id' => '9',
        ]);
        DB::table('tasks')->insert([
            'title' => 'Тема 19. Scout и полнотекстовый поиск',
            'module_id' => '9',
        ]);

    }
}
