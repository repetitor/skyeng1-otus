<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStudentTaskIdToStudentsTasksSkillsRaitings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students_tasks_skills_raitings', function (Blueprint $table) {
            $table->dropColumn('student_id');
            
            $table->unsignedBigInteger('student_task_id');
            $table->foreign('student_task_id')->references('id')->on('students_tasks');

            $table->unique(['student_task_id', 'skill_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students_tasks_skills_raitings', function (Blueprint $table) {
            $table->dropUnique(['student_task_id', 'skill_id']);
            $table->dropColumn('student_task_id');

            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students');
        });
    }
}
