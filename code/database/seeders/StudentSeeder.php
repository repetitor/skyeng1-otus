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
            'first_name' => 'Максим',
            'last_name' => 'Борисов',
        ]);
        DB::table('students')->insert([
            'first_name' => 'Сергей',
            'last_name' => 'Васильев',
        ]);
        DB::table('students')->insert([
            'first_name' => 'Нина',
            'last_name' => 'Кузнецова',
        ]);
        DB::table('students')->insert([
            'first_name' => 'Антонина',
            'last_name' => 'Федотова',
        ]);
        DB::table('students')->insert([
            'first_name' => 'Илья',
            'last_name' => 'Спиридонов',
        ]);
    }
}
