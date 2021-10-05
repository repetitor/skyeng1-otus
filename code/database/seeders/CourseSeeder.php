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
            'id' => 1,
            'title' => 'PHP Developer. Professional',
        ]);
        DB::table('courses')->insert([
            'id' => 2,
            'title' => 'PHP Developer. Basic',
        ]);
        DB::table('courses')->insert([
            'id' => 3,
            'title' => 'Framework Laravel',
        ]);
    }
}
