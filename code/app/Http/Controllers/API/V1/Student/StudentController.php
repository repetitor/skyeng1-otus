<?php


namespace App\Http\Controllers\API\V1\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Task;
use App\Models\StudentsTasks;
use App\Models\StudentsTasksSkillsRaitings;
use App\Http\Controllers\API\V1\Task\TaskController;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class StudentController extends Controller
{

    /**
     * @OA\Post (
     *     path="/api2/v1/student/{id}/rate-task",
     *     @OA\Parameter(name="id", in="path", description="The identifier of student.", example=1, required=true),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="task", example="1"),
     *                 @OA\Property(property="rating", example=7)
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK"),
     * )
     */
    public function rateTask($id, Request $request) {
        $this->_validate($id, $request);

        $data = [];

        $data[] = $this->asyncRequest( 'student_task_rate', array(
            'student_id' => $id,
            'task_id' => $request->get('task'),
            'rating' => $request->get('rating'),
        ) );

        $data[] = $this->asyncRequest( 'student_aggregation_tasks_skills', array(
            'student_id' => $id
        ) );
        $data[] = $this->asyncRequest( 'student_aggregation_time_today', array(
            'student_id' => $id
        ) );
        $data[] = $this->asyncRequest( 'student_aggregation_time_month', array(
            'student_id' => $id
        ) );
        $data[] = $this->asyncRequest( 'student_aggregation_courses', array(
            'student_id' => $id
        ) );

        return response($data, 200);
    }

    public function insertTaskRating( array $params ) : bool
    {
        if ( !$this->_validatePreInsert($params) ) {
            return false;
        }

        $student_id = $params['student_id'];
        $task_id = $params['task_id'];
        $rating = $params['rating'];

        $task_skills = DB::table('tasks_skills')->where('task_id', $task_id)->get();

        $students_tasks = new StudentsTasks();
        $students_tasks->fill([
            'student_id' => $student_id,
            'task_id' => $task_id,
            'rating' => $rating,
        ])->save();

        $students_tasks_id = $students_tasks->id;

        foreach ( $task_skills as $skill ) {
            $skill_rating = $rating * ( $skill->percent / 100 );
            $students_tasks_skills_ratings = new StudentsTasksSkillsRaitings();
            $students_tasks_skills_ratings->fill([
                'student_task_id' => $students_tasks_id,
                'skill_id' => $skill->skill_id,
                'raiting' => $skill_rating,
            ])->save();
        }

        return true;
    }

    private function _validate(string $id, Request $request)
    {
        if ( !$this->_validateStudentId($id) ) {
            return response('Student with ID='.$id.' doesn\'t exist.', 422);
        }

        $this->validate($request, [
            'task' => 'required',
            'rating' => 'required'
        ]);

        if ( !$this->_validateStudentTasks($id, (int) $request->get('task') ) ) {
            return response('This task for this student was already rated', 422);
        }

        if ( !$this->_validateTaskId((int) $request->get('task')) ) {
            return response('Task with ID-'.$id.' doesn\'t exist.', 422);
        }
        if ( !$this->_validateTaskSkills((int) $request->get('task')) ) {
            return response('Task has no skills.', 422);
        }

        if ( !$this->_validateRating((int) $request->get('rating')) ) {
            return response('Should not be less than ' . TaskController::MIN_RAITNG . ' or more than ' . TaskController::MAX_RATING, 422);
        }

    }

    private function _validatePreInsert( array $params)
    {
        if ( !$this->_validateStudentId($params['student_id']) ) {
            return false;
        }

        if ( !$this->_validateStudentTasks($params['student_id'], (int) $params['task_id'] ) ) {
            return false;
        }

        if ( !$this->_validateTaskId((int) $params['task_id']) ) {
            return false;
        }

        if ( !$this->_validateTaskSkills((int) $params['task_id']) ) {
            return false;
        }

        if ( !$this->_validateRating((int) $params['rating']) ) {
            return false;
        }

        return true;
    }

    private function _validateStudentId( string $id ) : bool
    {
        if (!Student::where('id', $id)->exists()) {
            return false;
        }
        return true;
    }
    private function _validateStudentTasks( string $id, int $task_id ) : bool
    {
        $students_tasks = StudentsTasks::where('student_id', $id)->where('task_id', $task_id)->count();
        if ( $students_tasks != 0 ) {
            return false;
        }
        return true;
    }
    private function _validateTaskId( string $id ) : bool
    {
        if (!Task::where('id', $id)->exists()) {
            return false;
        }
        return true;
    }
    private function _validateTaskSkills( string $id ) : bool
    {
        $task_skills = DB::table('tasks_skills')->where('task_id', $id)->count();

        if ( $task_skills == 0 ) {
            return false;
        }
        return true;
    }
    private function _validateRating( int $rating ) : bool
    {
        if ( !TaskController::validateRating( $rating ) ) {
            return false;
        }
        return true;
    }
}
