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
        $skills = [1,2,3,4];
        for ( $i = 1; $i <= 27; $i++  )
        {
            shuffle($skills);

            $num_skills = rand(1, 4);

            $task_skills = array_slice( $skills, 0, $num_skills );

            switch ( count( $task_skills ) )
            {
                case 1:
                    $skill_percents = [100];
                    break;
                case 2:
                    $skill_percents = [77,23];
                    break;
                case 3:
                    $skill_percents = [44,27,29];
                    break;
                case 4:
                    $skill_percents = [13,32,15,40];
                    break;
            }

            shuffle($skill_percents);

            for ( $j = 0; $j < count( $task_skills ); $j++ )
            {
                DB::table('tasks_skills')->insert([
                    'task_id' => $i,
                    'skill_id' => $task_skills[$j],
                    'percent' => $skill_percents[$j],
                ]);
            }
        }


    }
}
