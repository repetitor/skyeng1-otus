<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksSkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks_skills')->insert([
            'task_id' => '1',
            'skill_id' => '1',
            'percent' => '80',
        ]);
        DB::table('tasks_skills')->insert([
            'task_id' => '1',
            'skill_id' => '2',
            'percent' => '20',
        ]);
        DB::table('tasks_skills')->insert([
            'task_id' => '2',
            'skill_id' => '1',
            'percent' => '30',
        ]);
        DB::table('tasks_skills')->insert([
            'task_id' => '2',
            'skill_id' => '2',
            'percent' => '70',
        ]);
    }
}
