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
            'title' => 'task 1',
            'module_id' => '1',
        ]);
        DB::table('tasks')->insert([
            'title' => 'task 2',
            'module_id' => '1',
        ]);
        DB::table('tasks')->insert([
            'title' => 'task 3',
            'module_id' => '1',
        ]);
        DB::table('tasks')->insert([
            'title' => 'task 4',
            'module_id' => '2',
        ]);
        DB::table('tasks')->insert([
            'title' => 'task 5',
            'module_id' => '2',
        ]);
        DB::table('tasks')->insert([
            'title' => 'task 6',
            'module_id' => '5',
        ]);
        DB::table('tasks')->insert([
            'title' => 'task 7',
            'module_id' => '5',
        ]);
    }
}
