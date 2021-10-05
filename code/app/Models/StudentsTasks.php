<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentsTasks extends Model
{
    protected $table = 'students_tasks';
    protected $primaryKey = 'id';
    protected $fillable = [
        'student_id', 'task_id', 'rating'
    ];


}
