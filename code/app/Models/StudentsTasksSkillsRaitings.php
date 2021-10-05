<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsTasksSkillsRaitings extends Model
{
    protected $table = 'students_tasks_skills_raitings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'student_task_id', 'skill_id', 'raiting'
    ];


}
