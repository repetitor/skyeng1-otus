<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AwardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('awards')->insert([
            'title' => '5 задач курса выполнены больше чем на 6 балов',
            'alias' => '5_tasks_rated_above_6',
        ]);
        DB::table('awards')->insert([
            'title' => 'Выполнены все задания модуля',
            'alias' => 'all_module_tasks',
        ]);
    }
}
