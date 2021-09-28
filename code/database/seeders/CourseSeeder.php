<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
            'title' => 'course 1',
        ]);
        DB::table('courses')->insert([
            'title' => 'course 2',
        ]);
        DB::table('courses')->insert([
            'title' => 'course 3',
        ]);
        DB::table('courses')->insert([
            'title' => 'course 4',
        ]);
    }
}
