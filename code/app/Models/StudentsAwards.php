<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentsAwards extends Model
{
    protected $table = 'students_awards';
    protected $primaryKey = 'id';
    protected $fillable = [
        'student_id', 'award_id', 'params'
    ];


}
