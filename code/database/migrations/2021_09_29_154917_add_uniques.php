<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniques extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students_awards', function (Blueprint $table) {
            $table->unique(['student_id', 'award_id']);
        });
        Schema::table('tasks_skills', function (Blueprint $table) {
            $table->unique(['task_id', 'skill_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks_skills', function (Blueprint $table) {
            $table->dropUnique(['task_id', 'skill_id']);
        });
        Schema::table('students_awards', function (Blueprint $table) {
            $table->dropUnique(['student_id', 'award_id']);
        });
    }
}
