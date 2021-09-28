<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->insert([
            'first_name' => 'first_name student 1',
            'last_name' => 'last_name student 1',
        ]);
        DB::table('students')->insert([
            'first_name' => 'first_name student 2',
            'last_name' => 'last_name student 2',
        ]);
        DB::table('students')->insert([
            'first_name' => 'first_name student 3',
            'last_name' => 'last_name student 3',
        ]);
        DB::table('students')->insert([
            'first_name' => 'first_name student 4',
            'last_name' => 'last_name student 4',
        ]);
        DB::table('students')->insert([
            'first_name' => 'first_name student 5',
            'last_name' => 'last_name student 5',
        ]);
    }
}
