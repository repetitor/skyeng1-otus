<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('skills')->insert([
            'title' => 'Базы данных',
        ]);
        DB::table('skills')->insert([
            'title' => 'Архитектура',
        ]);
        DB::table('skills')->insert([
            'title' => 'ОП',
        ]);
        DB::table('skills')->insert([
            'title' => 'Алгоритмы',
        ]);
    }
}
