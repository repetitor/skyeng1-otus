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
    private $id = 0;
    private $task_id = 0;
    private $rating = 0;

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
     *                 @OA\Property(property="rating", example=37)
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK"),
     * )
     */
    public function rateTask($id, Request $request) {
        $this->id = $id;

        $this->_validate($request);

        $this->task_id = $request->get('task');
        $this->rating = $request->get('rating');

        $task_skills = DB::table('tasks_skills')->where('task_id', $this->task_id)->get();

        if ( $task_skills->isEmpty() ) {
            return response('Task has no skills.', 422);
        }

        $students_tasks = StudentsTasks::where('student_id', $this->id)->where('task_id', $this->task_id)->get();
        if ( !$students_tasks->isEmpty() )
        {
            return response('This task for this student was already rated', 422);
        }

        $students_tasks = new StudentsTasks();
        $students_tasks->fill([
            'student_id' => $this->id,
            'task_id' => $this->task_id,
            'rating' => $this->rating,
        ])->save();

        $students_tasks_id = $students_tasks->id;
$fill = [];

        foreach ( $task_skills as $skill ) {
            $rating = $this->rating * ( $skill->percent / 100 );
            $students_tasks_skills_ratings = new StudentsTasksSkillsRaitings();
            $students_tasks_skills_ratings->fill([
                'student_task_id' => $students_tasks_id,
                'skill_id' => $skill->skill_id,
                'raiting' => $rating,
            ])->save();
        }

        return response('Rating was added successfully', 200);
    }

    private function _validate(Request $request)
    {
        if (!Student::where('id', $this->id)->exists()) {
            return response('Student with ID='.$this->id.' doesn\'t exist.', 422);
        }

        $this->validate($request, [
            'task' => 'required',
            'rating' => 'required'
        ]);

        $response = [];

        if (!Task::where('id', $request->get('task') )->exists()) {
            $response['task'] = 'Doesn\'t exist';
        }

        if ( !TaskController::validateRating( (int) $request->get('rating') ) ) {
            $response['rating'] = 'Should not be less than ' . TaskController::MIN_RAITNG . ' or more than ' . TaskController::MAX_RATING;
        }

        if ( !empty( $response ) ) {
            return response([

            ], 422);
        }

    }
}
