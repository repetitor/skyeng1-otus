<?php


namespace App\Http\Controllers\API\V1\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentsTasks;
use App\Models\StudentsAwards as StudentsAwardsModel;
use App\Models\StudentsTasksSkillsRaitings;
use Illuminate\Support\Facades\DB;
use App\Validators\RateTaskValidator;
use App\Http\Controllers\API\V1\Student\StudentAwards as StudentAwardsController;

class StudentController extends Controller
{

    /**
     * Save rating of student
     *
     * @OA\Post (
     *     path="/api2/v1/student/{id}/rate-task",
     *     tags={"Student API"},
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
    public function rateTask(Request $request) {

        $rate_task_validator = new RateTaskValidator();
        $rate_task_validator->setStudentId($request->id);
        $rate_task_validator->setTaskId($request->task);
        $rate_task_validator->setRating($request->rating);
        if (!$rate_task_validator->validate()) {
            $error_message = $rate_task_validator->getErrorMessage();
            return response($error_message, 422);
        }

        $data = [];

        $data[] = $this->asyncRequest( 'student_task_rate', array(
            'student_id' => $request->id,
            'task_id' => $request->get('task'),
            'rating' => $request->get('rating'),
        ) );

        $data[] = $this->asyncRequest( 'student_aggregation_tasks_skills', array(
            'student_id' => $request->id
        ) );
        $data[] = $this->asyncRequest( 'student_aggregation_time_today', array(
            'student_id' => $request->id
        ) );
        $data[] = $this->asyncRequest( 'student_aggregation_time_month', array(
            'student_id' => $request->id
        ) );
        $data[] = $this->asyncRequest( 'student_aggregation_courses', array(
            'student_id' => $request->id
        ) );
        $data[] = $this->asyncRequest( 'student_receive_awards', array(
            'student_id' => $request->id
        ) );

        return response($data, 200);
    }

    public function insertTaskRating( array $params ) : bool
    {
        $student_id = $params['student_id'];
        $task_id = $params['task_id'];
        $rating = $params['rating'];

        $rate_task_validator = new RateTaskValidator();
        $rate_task_validator->setStudentId($student_id);
        $rate_task_validator->setTaskId($task_id);
        $rate_task_validator->setRating($rating);
        if (!$rate_task_validator->validate()) {
            return false;
        }

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

    /**
     * Get awards of student
     *
     * @OA\Get(
     *     path="/api2/v1/student/{id}/awards",
     *     tags={"Student API"},
     *     @OA\Parameter(name="id", in="path", description="The student-identifier.", example=1, required=true),
     *     @OA\Response(response="200", description="OK"),
     * )
     */
    public function getAwards(Request $request)
    {
        $student_id = $request->id;

        $awards = DB::select('
            SELECT
                awards.title,
                students_awards.created_at
            FROM students_awards
                LEFT JOIN awards on students_awards.award_id = awards.id
            WHERE
                students_awards.student_id=:id
        ', ['id'=>$student_id]);



        return $awards;
    }

    public function receiveAwards( array $params ) : bool
    {
        $student_id = $params['student_id'];

        $student_awards = new StudentAwardsController();
        $student_awards->receiveAwards($student_id);

        return true;
    }
}
