<?php

namespace App\Services;

class AggregationService
{
    public function getStudentAggregationByTimeToday(int $studentId)
    {
        return 'time-today-aggregation';
    }

    public function getStudentAggregationByTimeMonth(int $studentId)
    {
        return 'time-month-aggregation';
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
