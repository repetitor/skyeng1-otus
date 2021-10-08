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

    public function getAggregationForstudentByType(Request $request)
    {
        switch ($request->aggregation_type) {
            case Aggregation::TYPE_TIME:
                return $this->service->getStudentAggregationByTime($request->student_id);
            case Aggregation::TYPE_TASKS_SKILLS:
                return $this->service->getStudentAggregationByTasksSkills($request->student_id);
            case Aggregation::TYPE_COURSES:
                return $this->service->getStudentAggregationByCourses($request->student_id);
            default:
                return 'Такой тип агрегации отсутствует';
        }
    }
}
