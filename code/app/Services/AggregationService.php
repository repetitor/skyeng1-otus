<?php

namespace App\Services;

use App\Models\Aggregation;
use App\Storage\Redis;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\API\V1\Aggregation\AggregationController;
use App\Http\Controllers\Controller;

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
        if ( $result !== false ) {
            return $result;
        } else {
            $controller = new Controller();
            $controller->asyncRequest( 'student_aggregation_courses', array(
                'student_id' => $student_id
            ) );

            return ['message'=>'Aggregation was not calculated yet. Please try later.'];
        }

    }

    private function _getStudentAggregationByType( int $student_id, string $type )
    {
        $key = Redis::getKeyName( AggregationController::CACHE_KEY_TYPE_STUDENT, $type, $student_id );

        if (Cache::has($key)) {
            $result = json_decode( Cache::get($key), 1 );
            return $result;;
        }
        else {
            return false;
        }

    }
}
