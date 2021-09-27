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
            'title' => 'module 4',
            'course_id' => '1',
        ]);
        DB::table('modules')->insert([
            'title' => 'module 2',
            'course_id' => '1',
        ]);
        DB::table('modules')->insert([
            'title' => 'module 3',
            'course_id' => '1',
        ]);
        DB::table('modules')->insert([
            'title' => 'module 4',
            'course_id' => '2',
        ]);
        DB::table('modules')->insert([
            'title' => 'module 5',
            'course_id' => '2',
        ]);
    }
}
