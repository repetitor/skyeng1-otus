<?php


namespace App\Http\Controllers\API\V1\Aggregation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AggregationService;
use App\Models\Aggregation;

class AggregationController extends Controller
{
    private $service;

    public function __construct(AggregationService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api2/v1/aggregation/{aggregation_type}/student/{student_id}",
     *     @OA\Parameter(name="student_id", in="path", description="The student-identifier.", example=1, required=true),
     *     @OA\Parameter(
     *      name="aggregation_type",
     *      in="path",
     *      description="types: time-today, time-month, skills, courses",
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
}
