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
            'title' => 'award 1',
        ]);
        DB::table('awards')->insert([
            'title' => 'award 2',
        ]);
        DB::table('awards')->insert([
            'title' => 'award 3',
        ]);
    }
}
