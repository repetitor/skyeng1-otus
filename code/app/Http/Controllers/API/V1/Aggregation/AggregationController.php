<?php


namespace App\Http\Controllers\API\V1\Aggregation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AggregationService;
use App\Models\Aggregation;
use App\Storage\Redis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AggregationController extends Controller
{
    public const CACHE_KEY_TYPE_STUDENT = 'student_aggregation';

    private $service;

    public function __construct(AggregationService $service)
    {
        $this->service = $service;
    }

    /**
     * Get result of aggregation for student
     *
     * @OA\Get(
     *     path="/api2/v1/aggregation/{aggregation_type}/student/{student_id}",
     *     tags={"Aggregation API"},
     *     @OA\Parameter(name="student_id", in="path", description="The student-identifier.", example=1, required=true),
     *     @OA\Parameter(
     *      name="aggregation_type",
     *      in="path",
     *      description="types: time-today, time-month, tasks-skills, courses",
     *      example="time-today",
     *      required=true
     *     ),
     *     @OA\Response(response="200", description="OK"),
     * )
     */
    public function getAggregationForstudentByType(Request $request)
    {
        switch ($request->aggregation_type) {
            case Aggregation::TYPE_TIME_TODAY:
                return $this->service->getStudentAggregationByTimeToday($request->student_id);
            case Aggregation::TYPE_TIME_MONTH:
                return $this->service->getStudentAggregationByTimeMonth($request->student_id);
            case Aggregation::TYPE_TASKS_SKILLS:
                return $this->service->getStudentAggregationByTasksSkills($request->student_id);
            case Aggregation::TYPE_COURSES:
                return $this->service->getStudentAggregationByCourses($request->student_id);
            default:
                return 'Такой тип агрегации отсутствует';
        }
    }

    public function aggregateForStudentByType( int $student_id, string $type) : void
    {
        switch ($type) {
            case Aggregation::TYPE_TIME_TODAY:
                $this->_aggregateForStudentByTime( $student_id, Aggregation::TYPE_TIME_TODAY );
                break;
            case Aggregation::TYPE_TIME_MONTH:
                $this->_aggregateForStudentByTime( $student_id, Aggregation::TYPE_TIME_MONTH);
                break;
            case Aggregation::TYPE_TASKS_SKILLS:
                $this->_aggregateForStudentByTasksSkills( $student_id );
                break;
            case Aggregation::TYPE_COURSES:
                $this->_aggregateForStudentByCourses( $student_id );
                break;
            default:
                //return 'Такой тип агрегации отсутствует';
                break;
        }
    }

    private function _aggregateForStudentByTime( int $student_id, $type ) : void
    {
        switch ( $type )
        {
            case 'time-today':
                $interval = '1 day';
                break;
            case 'time-month':
                $interval = '1 month';
                break;
        }

        $result = DB::select('
            SELECT
                SUM(rating) as sum_rating
            FROM students_tasks
            WHERE student_id = :id
            AND created_at > NOW() - interval \''.$interval.'\'
        ', ['id' => $student_id] );

        Cache::put( Redis::getKeyName( self::CACHE_KEY_TYPE_STUDENT, $type, $student_id ) , json_encode( $result ), Redis::STORAGE_TIME_AGGREGATIONS_IN_MINUTES );
    }
    private function _aggregateForStudentByTasksSkills( int $student_id ) : void
    {
        $result = DB::select('
            SELECT
                SUM(st.rating) as sum,
                tasks.title as task_title,
                stsr2.skill_id as skill_id,
                stsr2.raiting as raiting,
                skills.title as title
	        FROM  students_tasks st
	        JOIN students_tasks_skills_raitings stsr2 ON  st.task_id = stsr2.student_task_id
	        join tasks on tasks.id = st.task_id
	        join skills on stsr2.skill_id = skills.id
	        where st.student_id = :id
	        group by tasks.title,stsr2.skill_id,stsr2.raiting,skills.title
	        order by sum desc
        ', ['id' => $student_id] );

        foreach ( $result as $row ) {
            $format_array[$row->task_title][] = ['total_raiting' => $row->sum,
                'skill_name'      => $row->title,
                'skill_raiting'   => $row->raiting];
        }

        // АЧИВКА
        Cache::put( Redis::getKeyName( self::CACHE_KEY_TYPE_STUDENT, Aggregation::TYPE_TASKS_SKILLS, $student_id ) , json_encode( $format_array ), Redis::STORAGE_TIME_AGGREGATIONS_IN_MINUTES );

    }
    private function _aggregateForStudentByCourses( int $student_id ) : void
    {
        $result = DB::select('
            SELECT
                  courses.title as courses_title,
                  modules.title as modules_title,
                  SUM( students_tasks_skills_raitings.raiting )

            FROM students_tasks_skills_raitings, students_tasks
                LEFT JOIN tasks ON tasks.id = students_tasks.task_id
                LEFT JOIN modules ON modules.id = tasks.module_id
                LEFT JOIN courses ON courses.id = modules.course_id

            WHERE
              students_tasks_skills_raitings.student_task_id = students_tasks.id
              AND
              students_tasks.student_id = :id
            GROUP BY courses.title, modules.title
            ORDER BY courses.title, modules.title
        ', ['id' => $student_id] );

        $result_2 = [];
        foreach ( $result as $row )
        {
            if ( empty( $result_2[ $row->courses_title ] ) )
            {
                $result_2[ $row->courses_title ] = [];
            }
            $result_2[ $row->courses_title ][ $row->modules_title ] = $row->sum;
        }

        Cache::put( Redis::getKeyName( self::CACHE_KEY_TYPE_STUDENT, Aggregation::TYPE_COURSES, $student_id ) , json_encode( $result_2 ), Redis::STORAGE_TIME_AGGREGATIONS_IN_MINUTES );

    }
}
