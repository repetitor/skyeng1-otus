<?php


namespace App\Http\Controllers\API\V1\Aggregation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AggregationService;
use App\Models\Aggregation;

class AggregationController extends Controller
{
//    private AggregationService $service; // надо чтоб php >= 7.4
    private $service;

    public function __construct(AggregationService $service)
    {
        $this->service = $service;
    }

    public function getAggregationForstudentByType(Request $request)
    {
        switch ($request->type) {
            case Aggregation::TYPE_TIME:
                return $this->service->aggregateStudentByTime($request->student_id);
            case Aggregation::TYPE_TASKS_SKILLS:
                return $this->service->aggregateStudentByTasksSkills($request->student_id);
            case Aggregation::TYPE_COURSES:
                return $this->service->aggregateStudentByCourses($request->student_id);
            default:
                echo 'Такой тип агрегации отсутствует';
        }

        return 1;
    }
}
