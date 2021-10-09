<?php

namespace App\Services;

use App\Models\Aggregation;
use App\Storage\Redis;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\API\V1\Aggregation\AggregationController;

class AggregationService
{
    public function getStudentAggregationByTimeToday(int $student_id) : array
    {
        $result = $this->_getStudentAggregationByType( $student_id, Aggregation::TYPE_TIME_TODAY);
        return $result;
    }

    public function getStudentAggregationByTimeMonth(int $student_id) : array
    {
        $result = $this->_getStudentAggregationByType( $student_id, Aggregation::TYPE_TIME_MONTH);
        return $result;
    }

    public function getStudentAggregationByTasksSkills(int $student_id) : array
    {
        $result = $this->_getStudentAggregationByType( $student_id, Aggregation::TYPE_TASKS_SKILLS );
        return $result;
    }

    public function getStudentAggregationByCourses(int $student_id) : array
    {
        $result = $this->_getStudentAggregationByType( $student_id, Aggregation::TYPE_COURSES );
        return $result;
    }

    private function _getStudentAggregationByType( int $student_id, string $type ) : array
    {
        $key = Redis::getKeyName( AggregationController::CACHE_KEY_TYPE_STUDENT, $type, $student_id );

        $result = [];

        if (Cache::has($key)) {
            $result = json_decode( Cache::get($key), 1 );
        }

        return $result;
    }
}
