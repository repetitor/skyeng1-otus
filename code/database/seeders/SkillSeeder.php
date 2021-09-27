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
            'title' => 'skill1',
        ]);
        DB::table('skills')->insert([
            'title' => 'skill2',
        ]);
        DB::table('skills')->insert([
            'title' => 'skill3',
        ]);
        DB::table('skills')->insert([
            'title' => 'skill4',
        ]);
    }
}
