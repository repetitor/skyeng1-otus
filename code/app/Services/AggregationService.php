<?php

namespace App\Services;

class AggregationService
{
    public function getStudentAggregationByTime(int $studentId)
    {
        return 'time-aggregation';
    }

    public function getStudentAggregationByTasksSkills(int $studentId)
    {
        return 'tasks-skills-aggregation';
    }

    public function getStudentAggregationByCourses(int $studentId)
    {
        return 'courses-aggregation';
    }
}
