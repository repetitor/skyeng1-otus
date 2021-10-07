<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            'id' => 1,
            'title' => 'Общие знания',
            'course_id' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => 2,
            'title' => 'Базы данных',
            'course_id' => '1',
        ]);
        DB::table('modules')->insert([
            'id' => 3,
            'title' => 'Практики разработки',
            'course_id' => '1',
        ]);


        DB::table('modules')->insert([
            'id' => 4,
            'title' => 'Алгоритмическая подготовка и базовые понятия',
            'course_id' => '2',
        ]);
        DB::table('modules')->insert([
            'id' => 5,
            'title' => 'Базы данных',
            'course_id' => '2',
        ]);
        DB::table('modules')->insert([
            'id' => 6,
            'title' => 'Основные понятия экосистемы и языка PHP',
            'course_id' => '2',
        ]);


        DB::table('modules')->insert([
            'id' => 7,
            'title' => 'Знакомство с фреймворком. Пишем базовый функционал',
            'course_id' => '2',
        ]);
        DB::table('modules')->insert([
            'id' => 8,
            'title' => 'Продолжаем усложнять логику проекта',
            'course_id' => '2',
        ]);
        DB::table('modules')->insert([
            'id' => 9,
            'title' => 'API',
            'course_id' => '2',
        ]);
    }
}
