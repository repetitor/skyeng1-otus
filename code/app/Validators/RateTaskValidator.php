<?php

namespace App\Validators;

use App\Validators\ValidatorInterface;
use App\Http\Controllers\API\V1\Task\TaskController;
use App\Models\Student;
use App\Models\StudentsTasks;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class RateTaskValidator implements ValidatorInterface
{
    private $message = '';

    private $tasks = [];

    private $student_id;
    private $task_id;
    private $rating;

    public function __construct()
    {
        $this->tasks = [
            'validate_student',
            'validate_task',
            'validate_students_tasks',
            'validate_task_skills',
            'validate_rating',
        ];
    }

    public function setStudentId( int $id ) : void
    {
        $this->student_id = $id;
    }
    public function setTaskId( int $id ) : void
    {
        $this->task_id = $id;
    }
    public function setRating( int $rating ) : void
    {
        $this->rating = $rating;
    }

    public function getErrorMessage() : string
    {
        return $this->message;
    }

    public function setTasks(array $tasks) : void
    {
        $this->tasks = $tasks;
    }

    public function validate() : bool
    {
        /*print_r([
            'student_id'=>$this->student_id,
            'task_id'=>$this->task_id,
            'rating'=>$this->rating,
        ]);*/

        foreach ( $this->tasks as $task )
        {
            switch ( $task )
            {
                case 'validate_student':
                    if ( !$this->_validateStudentId() ) {
                        $this->message = 'Student ID is not valid';
                        return false;
                    }
                    break;
                case 'validate_task':
                    if ( !$this->_validateTaskId() ) {
                        $this->message = 'Task ID is not valid';
                        return false;
                    }
                    break;
                case 'validate_students_tasks':
                    if ( !$this->_validateStudentTasks() ) {
                        $this->message = 'This task for this student is already rated.';
                        return false;
                    }
                    break;
                case 'validate_task_skills':
                    if ( !$this->_validateTaskSkills() ) {
                        $this->message = 'Task has no skills';
                        return false;
                    }
                    break;
                case 'validate_rating':
                    if ( !$this->_validateRating() ) {
                        $this->message = 'Rating is not valid';
                        return false;
                    }
                    break;
                default:
                    $this->message = 'Can\'t validate task "'.$task.'".';
                    return false;
                    break;
            }
        }

        return true;
    }
    private function _validateStudentId() : bool
    {
        if ( empty($this->student_id) ) {
            return false;
        }

        if (!Student::where('id', $this->student_id)->exists()) {
            return false;
        }
        return true;
    }

    private function _validateTaskId() : bool
    {
        if ( empty($this->task_id) ) {
            return false;
        }

        if (!Task::where('id', $this->task_id)->exists()) {
            return false;
        }
        return true;
    }

    private function _validateStudentTasks() : bool
    {
        $students_tasks = StudentsTasks::where('student_id', $this->student_id)->where('task_id', $this->task_id)->count();
        if ( $students_tasks != 0 ) {
            return false;
        }
        return true;
    }

    private function _validateTaskSkills() : bool
    {
        $task_skills = DB::table('tasks_skills')->where('task_id', $this->task_id)->count();

        if ( empty($task_skills) ) {
            return false;
        }
        return true;
    }

    private function _validateRating() : bool
    {
        if ( !TaskController::validateRating($this->rating) ) {
            return false;
        }
        return true;
    }
}
